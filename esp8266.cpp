/*
  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
    Blog:       https://parzibyte.me/blog
    Ayuda:      https://parzibyte.me/blog/contrataciones-ayuda/
    Contacto:   https://parzibyte.me/blog/contacto/
    
    Copyright (c) 2020 Luis Cabrera Benito
    Licenciado bajo la licencia MIT
    
    El texto de arriba debe ser incluido en cualquier redistribucion
*/
#include "DHT.h"
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

// Credentials to connect to the wifi network
const String SSID = "RED";
const String PASSWORD = "PASSWORD";
/*
The ip or server address. If you are on localhost, put your computer's IP (for example http://192.168.1.65)
If the server is online, put the server's domain for example https://parzibyte.me
*/
const String SERVER_ADDRESS = "http://192.168.1.82/esp8266_dht";

#define DHT_CONNECTION_PIN D1 // Pin connected to "out" pin in DHT sensor
#define SENSOR_TYPE DHT22
#define STATUS_LED 2

DHT sensor(DHT_CONNECTION_PIN, SENSOR_TYPE);

float humidity, temperature = 0;

int lastTimeRead = 0;
long readDataInterval = 30000; // Must be greater than 2 seconds (2000 miliseconds)

void setup()
{

  // Led
  pinMode(STATUS_LED, OUTPUT);
  digitalWrite(STATUS_LED, LOW);

  sensor.begin();

  // Connect to wifi
  WiFi.begin(SSID, PASSWORD);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
  }
  digitalWrite(STATUS_LED, HIGH);
}

void indicateDhtError()
{
  int x = 0;
  for (x = 0; x < 5; x++)
  {
    digitalWrite(STATUS_LED, LOW);
    delay(50);
    digitalWrite(STATUS_LED, HIGH);
    delay(50);
  }
}

void indicateDhtSuccess()
{
  digitalWrite(STATUS_LED, LOW);
  delay(50);
  digitalWrite(STATUS_LED, HIGH);
}

void loop()
{

  if (WiFi.status() != WL_CONNECTED)
  {
    return;
  }

  // Read data if interval has been reached
  if (lastTimeRead > readDataInterval)
  {
    humidity = sensor.readHumidity();
    temperature = sensor.readTemperature();
    // Check if data is ok
    if (isnan(temperature) || isnan(humidity))
    {
      indicateDhtError();
      lastTimeRead = 0;
      return;
    }
    HTTPClient http;

    // Setup data url
    String full_url = SERVER_ADDRESS + "/save_data.php?temperature=" + temperature + "&humidity=" + humidity;
    http.begin(full_url);

    // Make request
    int httpCode = http.GET();
    if (httpCode > 0)
    {
      if (httpCode == HTTP_CODE_OK)
      {
        // Handle success
        indicateDhtSuccess();
      }
      else
      {
        //Handle error
      }
    }
    else
    {
      // Handle error
    }

    http.end(); //Close connection

    lastTimeRead = 0;
  }

  // Here you can do more things...
  delay(10);
  lastTimeRead += 10;
}