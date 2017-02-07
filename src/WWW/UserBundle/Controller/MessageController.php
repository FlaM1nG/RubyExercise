<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller{
    
    private $session;
    private $ut;
    
    public function listMessageSentAction(Request $request){
        $this->setUpVars($request);
        
        $messageSent = $this->searchMessageFrom($request);
        
        return $this->render('UserBundle:Profile:messageSent.html.twig',
                       array('messages' => $messageSent));
        
    }
    
    public function listMessageReceivedAction(Request $request){
        $this->setUpVars($request);
        
        $messageReceived = $this->searchMessageTo($request);
        
        return $this->render('UserBundle:Profile:messageReceived.html.twig',
                       array('messages' => $messageReceived));
        
    }
    
    public function newMessageAction(Request $request){
        $this->setUpVars($request);
        
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()):
            $result = $this->sendMessage($request, $message);
            if($result == 'ok'):
                return $this->forward('UserBundle:Message:listMessageSent');
            endif;
        endif;
        
        return $this->render('UserBundle:Profile:newMessageProfile.html.twig',
                        array('form' => $form->createView())   
                );
    }
    
    private function setUpVars(Request $request){
        
        $this->session = $request->getSession();
        
        $this->ut = new Utilities();
       
        if(empty($this->session->get('num_messages'))): 
            $this->session->set('numMessage',$this->ut->messageNoRead($request));
        endif;

    }
    
    private function searchMessageFrom(Request $request){
        
        $file = MyConstants::PATH_APIREST."user/messages/list_messages.php";
        $ch = new ApiRest();
        $arraySent = null;
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['mode'] = 'from';
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] != 'ok'):
            $this->ut->flashMessage("general", $request, $result);
        else:    
            
            foreach($result['messages'] as $data):
               $arraySent[] = new Message($data);
            endforeach;
        endif;
        
        return $arraySent;
    }
    
    private function searchMessageTo(Request $request){
        
        $file = MyConstants::PATH_APIREST."user/messages/list_messages.php";
        $ch = new ApiRest();
        $messages = null;
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['mode'] = 'to';
        
        $result = $ch->resultApiRed($data, $file);
       
        if($result['result'] != 'ok'):
            $this->ut->flashMessage("general", $request, $result);
            return null;
        else:
            foreach($result['messages'] as $data):
                $messages[] = new Message($data);
            endforeach; 
        endif;    
        
        return $messages;
    }
    
    public function searchMessageAction(Request $request){
        
        $formMessage = null;
        $messageReply = null;
        $this->setUpVars($request);
        $id = $request->get('idMessage');

        $message = $this->getMessage($id);
        $type = 'received';
        
        if($message->getFrom()->getId() == $request->getSession()->get('id')):
            $type = 'send';
        else:
            $messageReply = new Message();
            $messageReply->setSubject('Re: '.$message->getSubject());
            $messageReply->setFrom($message->getTo());
            $messageReply->setTo($message->getFrom());
            
            $form = $this->createForm(MessageType::class,$messageReply);
            $formMessage = $form->createView();
            
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->get('enviar')->isClicked()):
                $result = $this->sendMessage($request, $messageReply);
            
                if($result == 'ok'):
                    $this->forward('UserBundle:Message:listMessageReceived');
                endif;
            endif;
        endif;
        
        return $this->render("UserBundle:Profile:readMessage.html.twig",
                             array('mensaje' => $message,
                                   'type' => $type,
                                   'form' => $formMessage));
    }
    
    public function getMessage($id){
   
        $file = MyConstants::PATH_APIREST."user/messages/get_message.php"; 
        $ch = new ApiRest();
        $message = null;
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['message_id'] = $id;
        
        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok')
            $message = new Message($result);
        
        return $message;
        
    }
    
    private function sendMessage(Request $request, $message){
        
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php"; 
        $ch = new ApiRest();
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['to'] = $message->getTo()->getUsername();
        $data['subject'] = $message->getSubject(); 
        $data['message'] = $message->getMessage();       

        $result = $ch->resultApiRed($data, $file);

        $this->ut->flashMessage("message", $request, $result);
        
        return $result['result'];
   
    }
    
    public function removeMessageAction(Request $request){
           
        $id = $request->get('id');
        $session = $request->getSession();
        
        $response = new JsonResponse();
        
        $file = MyConstants::PATH_APIREST."user/messages/delete_message.php";
        $ch = new ApiRest();
        
        $data['username'] = $session->get('username');
        $data['id'] = $session->get('id');
        $data['password'] = $session->get('password');
        $data['message_id'] = $id;
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok'):
            $response->setData(array(
                'result' => 'ok',
                'message' => 'Mensaje eliminado correctamente'));
        else:
             $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo'));
        endif;
        
        return $response;
               
    }

}
