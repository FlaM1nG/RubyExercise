require 'nokogiri'
require 'open-uri'
require 'JSON'


# declaramos el array result con 0 elementos
result = [];


#Creamos una función para devolver falso o verdadero en notifications
def condition(name)
#Forzamos el texto a Mayusculas
	if name.css('span').text.upcase == "NO"
		return false
   	end
   	return true
end

# Obtenemos la pagina para recolectar los datos
page = Nokogiri::HTML(open("https://www.port-monitor.com/plans-and-pricing"))

# Sacamos los elementos que se nos pide del html
products = page.css('.product')

#Hacemos un for para ir sacando todos los elementos del array

products.each do |product|

	array = {
	  'monitors' => product.css('h2').text,
	  'check_rate' => product.css('.thin').css('dd')[0].text.delete('^[0-9]'),
	  'history' => product.css('.thin').css('dd')[1].text.delete('^[0-9]'),
	  'multiple_notifications' => condition(product.css('.thin').css('dd')[2]),
	  'push_notifications' => condition(product.css('.thin').css('dd')[3]),
	  'price' => product.css('a')[2].text.delete('^.[0-9]')
	}
	result << array
end

#Mostramos por pantalla el resultado por JSON
puts JSON[result]
