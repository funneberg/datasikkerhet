package com.example.datasikkerhetapp;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import java.net.HttpURLConnection;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //HttpURLConnection connection =

        Button btnLogIn = findViewById(R.id.btnLogIn);
        final TextView textView = findViewById(R.id.txtTest);


        btnLogIn.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                CharSequence charSequence = "o o f";
                textView.setText(charSequence);
            }
        });


    }
}
