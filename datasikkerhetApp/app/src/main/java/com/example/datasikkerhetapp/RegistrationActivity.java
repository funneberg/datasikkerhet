package com.example.datasikkerhetapp;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class RegistrationActivity extends AppCompatActivity {

    private EditText name, email, fieldOfStudy, year, password;
    private Button btnRegister;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registration);

        name = findViewById(R.id.txtName);
        email = findViewById(R.id.txtEmail);
        fieldOfStudy = findViewById(R.id.txtFieldOfStudy);
        year = findViewById(R.id.numYear);
        password = findViewById(R.id.txtPassword);
        btnRegister = findViewById(R.id.btnRegister2);

        btnRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                String sName = name.getText().toString().trim();
                String sEmail = email.getText().toString().trim();
                String sFieldOfStudy = fieldOfStudy.getText().toString().trim();
                int intYear = Integer.parseInt(year.getText().toString().trim());
                String sPassword = password.getText().toString().trim();



                /*
                if (!sName.equals("") && !sEmail.equals("") && !sFieldOfStudy.equals("") && intYear != 0 && !sPassword.equals("")) {
                    PHPConnection.signUp(sName, sEmail, sFieldOfStudy, intYear, sPassword);
                    //PHPConnection.logIn(sEmail, sPassword);
                }

                 */

                startActivity(new Intent(RegistrationActivity.this, MainActivity.class));
            }
        });
    }

    /*
    private getData(String url) {
        class GetData extends AsyncTask<String, Void, String>{
            protected String doInBackground(String... params) {
                String uri = params[0];
                BufferedReader br = null;
                try {
                    URL url = new URL(uri);
                    HttpURLConnection con = (HttpURLConnection) url.openConnection();
                    StringBuilder sb = new StringBuilder();
                    br = new BufferedReader(new InputStreamReader(con.getInputStream()));

                }
                catch (IOException ioe) {
                    return null;
                }
            }
        }
    }

     */
}
