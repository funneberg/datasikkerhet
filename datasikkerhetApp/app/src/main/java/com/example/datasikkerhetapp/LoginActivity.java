package com.example.datasikkerhetapp;

import androidx.appcompat.app.AppCompatActivity;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.datasikkerhetapp.mysql_connection.PostRequestHandler;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

public class LoginActivity extends AppCompatActivity {

    private static final String IP_ADRESS = "158.39.167.241";
    private static final String URL_LOGIN = "http://"+IP_ADRESS+"/datasikkerhet/php_test/php/login.php";

    private EditText email, password;
    private SharedPreferences sharedPreferences;

    public static final String MY_PREFERENCES = "MyPrefs";
    public static final String EMAIL = "email";
    public static final String STATUS = "status";
    public static final String NAME = "name";
    public static final String FIELD_OF_STUDY = "fieldOfStudy";
    public static final String YEAR = "year";
    private boolean status;

    private Button btnLogin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        email = findViewById(R.id.txtEmail2);
        password = findViewById(R.id.txtPassword2);
        btnLogin = findViewById(R.id.btnLogin2);

        sharedPreferences = getSharedPreferences(MY_PREFERENCES, Context.MODE_PRIVATE);

        status = sharedPreferences.getBoolean(STATUS, false);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                final String sEmail = email.getText().toString();
                final String sPassword = password.getText().toString();

                if(sEmail.isEmpty()|| sPassword.isEmpty()){
                    Toast.makeText(LoginActivity.this, "Alle feltene må fylles ut", Toast.LENGTH_SHORT).show();
                }

                else {
                    class Login extends AsyncTask<Void, Void, String> {
                        ProgressDialog pdLoading = new ProgressDialog(LoginActivity.this);

                        @Override
                        protected void onPreExecute() {
                            super.onPreExecute();

                            //this method will be running on UI thread
                            pdLoading.setMessage("\tLoading...");
                            pdLoading.setCancelable(false);
                            pdLoading.show();
                        }

                        @Override
                        protected String doInBackground(Void... voids) {
                            //creating request handler object
                            PostRequestHandler requestHandler = new PostRequestHandler();

                            //creating request parameters
                            HashMap<String, String> params = new HashMap<>();
                            params.put("email", sEmail);
                            params.put("password", sPassword);

                            //returing the response
                            return requestHandler.sendPostRequest(URL_LOGIN, params);
                        }

                        @Override
                        protected void onPostExecute(String s) {
                            super.onPostExecute(s);
                            pdLoading.dismiss();

                            System.out.println("JSON-string: " + s);

                            try {
                                //converting response to json object
                                JSONObject obj = new JSONObject(s);
                                //if no error in response
                                if (!obj.getBoolean("error")) {
                                    String name = obj.getString("name");
                                    String fieldOfStudy = obj.getString("fieldOfStudy");
                                    String year = obj.getString("year");

                                    Account.setActiveUser(name, sEmail, fieldOfStudy, year);

                                    /*
                                    SharedPreferences.Editor editor = sharedPreferences.edit();
                                    editor.putString(NAME, name);
                                    editor.putString(EMAIL, sEmail);
                                    editor.putString(FIELD_OF_STUDY, fieldOfStudy);
                                    editor.putString(YEAR, year);
                                    editor.putBoolean(STATUS, true);
                                    editor.apply();

                                     */

                                    finish();
                                    Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
                                    startActivity(new Intent(LoginActivity.this, MainActivity.class));
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(LoginActivity.this, "Exception: " + e, Toast.LENGTH_LONG).show();
                                System.out.println("Exception: " + e);
                            }
                        }
                    }

                    Login login = new Login();
                    login.execute();
                }
            }
        });

        if (status){

            //SharedPreferences.Editor editor = sharedPreferences.edit();
            //editor.putBoolean(STATUS, false);
            //editor.apply();

            finish();
            startActivity(new Intent(LoginActivity.this, MainActivity.class));
        }
    }
}
