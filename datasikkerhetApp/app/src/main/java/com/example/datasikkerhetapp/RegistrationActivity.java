package com.example.datasikkerhetapp;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

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
                //...
            }
        });
    }
}
