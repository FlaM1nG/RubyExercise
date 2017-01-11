<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Form\ProfileMessageType;
use WWW\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller{
    
    private $session;
    private $ut;
    private $message;
    private $user;
    
    public function messageAction(Request $request,User $user){
        //print_r($request);
        $this->setUpVars($request,$user);

        $this->searchMessageFrom($request);
        $this->searchMessageTo($request);
        
        $formMessage = $this->createForm(MessageType::class,$this->message); 
        
//        $formListMessages = $this->createForm(ProfileMessageType::class, $this->user);
       
        $formMessage->handleRequest($request);
        
//        $formListMessages->handleRequest($request);

        if($formMessage->isSubmitted()):
            if($formMessage->get('enviar')->isClicked()):
                $this->sendMessage($request);
//            else:  
//                if(!empty($request->request->all()['profileMessage']['fromTo'])): 
//                    $this->removeMessage($request);
//                    //Al haber actualizado el usuario hay que volver a crear el formulario
//                    $formListMessages = $this->createForm(ProfileMessageType::class, $this->user);
//                endif;
        
            endif;
        endif;    

        return $this->render('UserBundle:Default:profileMessage.html.twig',
                             array('formMessage' => $formMessage->createView(),
                                   'listMessagesSend' => $this->user->getSent(),
                                   'listMessageReceived' => $this->user->getReceived() ));

    }
    
    private function setUpVars(Request $request,$user = null){
        
        $this->session = $request->getSession();
        
        $this->ut = new Utilities();
        
        $this->message = new Message();
        $this->user = $user;

    }
    
    private function searchMessageFrom(Request $request){
        
        $file = MyConstants::PATH_APIREST."user/messages/list_messages.php";
        $ch = new ApiRest();
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['mode'] = 'from';
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] != 'ok'):
            $this->ut->flashMessage("general", $request, $result);
        else:    
            
            foreach($result['messages'] as $data):
               $this->user->addSent(new Message($data));
            endforeach;
        endif;
    }
    
     private function searchMessageTo(Request $request){
        
        $file = MyConstants::PATH_APIREST."user/messages/list_messages.php";
        $ch = new ApiRest();
        
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
                $this->user->addReceived(new Message($data));
            endforeach; 
        endif;    
        
        
    }
    
    public function searchMessageAction(Request $request){
        
        $this->setUpVars($request);
        $id = $request->get('idMessage');

        $this->getMessage($request, $id);

        $form = $this->createForm(MessageType::class,$this->message); 
        $form->handleRequest($request);
       
        if($form->isSubmitted()):
            $this->sendMessage($request);
            return $this->redirectToRoute('user_profiler');
        endif;
        
        return $this->render("UserBundle:Message:showMessage.html.twig",
                             array('message' => $this->message,
                                   'form' => $form->createView()));
    }
    
    public function getMessage(Request $request, $id){
   
        $file = MyConstants::PATH_APIREST."user/messages/get_message.php"; 
        $ch = new ApiRest();
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['message_id'] = $id;
        
        $result = $ch->resultApiRed($data, $file);

        $this->message = new Message($result);
        
        if(array_key_exists('result', $result))
            $this->ut->flashMessage("general", $request, $result);
        
    }
    
    private function sendMessage(Request $request){
        
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php"; 
        $ch = new ApiRest();
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['to'] = $this->message->getFrom()->getUsername();
        $data['subject'] = $this->message->getSubject(); 
        $data['message'] = $this->message->getMessage();       

        $result = $ch->resultApiRed($data, $file);

        $this->ut->flashMessage("message", $request, $result);
   
    }
    
    public function removeMessageAction(Request $request){
           
        $id = $request->get('id');
        $type = $request->get('type');
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