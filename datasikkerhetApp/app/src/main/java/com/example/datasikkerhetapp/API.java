package com.example.datasikkerhetapp;

import java.net.*;
import java.io.*;


public class API {
    public void sendLogin(String id, String passord){
        String URL = "http://158.39.188.205/" + "/?id=" + id + "&passord=" + passord + "&logginn=";
    }

    public String getInformasjon(String side) throws Exception {
       String info = URLReader(side);
       //Endrer PHP whitespace til vanlig whitespace
        info.replaceAll("%20", " ");
        //Fjerner alle symboler som ikke er alphanumeriske, utenom "=" og whitespace
        info.replaceAll("[^\\p{IsAlphabetic}\\p{IsDigit}=\\s]", "");
        return info;
    }

    //Henter URL informasjon fra en side, og sender tilbake alt den får
    public static String URLReader(String side) throws Exception {

        URL nettside = new URL("http://158.39.188.205/" + side);
        BufferedReader in = new BufferedReader(
                new InputStreamReader(nettside.openStream())
        );

        String inputLine;
        String sendLine = null;
        while ((inputLine = in.readLine()) != null)
            sendLine += inputLine;
        in.close();
        return sendLine;
    }

}
