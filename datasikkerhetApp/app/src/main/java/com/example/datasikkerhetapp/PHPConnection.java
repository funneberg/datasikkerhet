package com.example.datasikkerhetapp;

import com.example.datasikkerhetapp.model.Course;

import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

public class PHPConnection {

    public static void signUp(String name, String email, String fieldOfStudy, int year, String password) {
        try {
            String request = "localhost/datasikkerhet/register.php?yourname=" + name + "&email=" + email + "&fieldOfStudy=" +
                                fieldOfStudy + "&year=" + year + "&password=" + password;
            URL url = new URL(request);
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            connection.setDoOutput(true);
            connection.setInstanceFollowRedirects(false);
            connection.setRequestMethod("GET");
            connection.setRequestProperty("Content-Type", "text/plain");
            connection.setRequestProperty("charset", "utf-8");
            connection.connect();
        }
        catch (IOException ioe) {
            ioe.getStackTrace();
        }

    }

    public static ArrayList<Course> loadCourses() {
        ArrayList<Course> courses = new ArrayList<>();



        return courses;
    }

}
