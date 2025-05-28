//Incluir librerias
#include <ESP8266WiFi.h>
#include <DHT.h>
#include <DHT_U.h>

const char* ssid = "Red"; //"Aquí el nombre de tu red"
const char* password = "contraseña"; //"Aquí la contraseña de tu red"

const char* host = "Nombre del host"; //Por ejemplo: miservidor.com

//Definiendo el modelo de sensor y el pin al que estará conectado
#define DHTTYPE DHT22
#define DHTPIN 4 //GPIO4
DHT dht(DHTPIN, DHTTYPE, 22);

//Variables para Humedad y Temperatura
float temperatura;
float humedad;

//Variable Hidrogeno
int hidrogeno = analogRead(A0);

void setup(){
  Serial.begin(115200);
  Serial.println();

  dht.begin();

  pinMode(16,OUTPUT);
  pinMode(2,OUTPUT);

  Serial.printf("Connecting to %s ", ssid);
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.println(" connected");
}

void loop(){

  if(temperatura>=25 || hidrogeno>=700){
    digitalWrite(2,LOW);
    }else{
      digitalWrite(2,HIGH);
      }
  
  WiFiClient client;

  Serial.printf("\n[Connecting to %s ...", host);
  if (client.connect(host, 80))
  {
      Serial.println("connected]");

      temperatura = dht.readTemperature();
      humedad = dht.readHumidity();
     

      Serial.println("[Sending a request]");
      client.print(String("GET /?Temp=") + temperatura + "&Hum=" + humedad +  "?Hid" + hidrogeno +  " HTTP/1.1\r\n"+
                   "Host: " + host + "\r\n" +
                   "Connection: close\r\n" +
                   "\r\n"
                   );

      Serial.println("[Response:]");
      while (client.connected())
      {
        if (client.available())
        {
          String line = client.readStringUntil('\n');
          Serial.println(line);
          digitalWrite(16,HIGH);
        }
      }
      client.stop();
      Serial.println("\n[Disconnected]");
      Serial.println(temperatura);
  }
  else
  {
    Serial.println("connection failed!]");
    client.stop();
    digitalWrite(16,LOW);
    
  }
  delay(5000);
}
