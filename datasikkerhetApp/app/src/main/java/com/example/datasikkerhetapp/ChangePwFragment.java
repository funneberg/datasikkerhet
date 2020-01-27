package com.example.datasikkerhetapp;


import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.fragment.app.Fragment;

import com.example.datasikkerhetapp.mysql_connection.PostRequestHandler;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

public class ChangePwFragment extends Fragment {

    private static final String IP_ADRESS = "158.39.167.241";

    private static final String URL_CHANGE_PASSWORD = "http://"+IP_ADRESS+"/datasikkerhet/php_test/php/changepassword.php";

    private EditText etOldPassword;
    private EditText etNewPassword1;
    private EditText etNewPassword2;
    private Button btnChangePassword;

    public ChangePwFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_change_pw, container, false);

        etOldPassword = view.findViewById(R.id.txtOldPassword);
        etNewPassword1 = view.findViewById(R.id.txtNewPassword);
        etNewPassword2 = view.findViewById(R.id.txtNewPassword2);
        btnChangePassword = view.findViewById(R.id.btnChangePw);

        btnChangePassword.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String sEmail = Account.getActiveUser().getEmail();
                final String sOldPassword = etOldPassword.getText().toString();
                final String sNewPassword1 = etNewPassword1.getText().toString();
                final String sNewPassword2 = etNewPassword2.getText().toString();

                System.out.println("Verdier: " + sEmail + ", " + sOldPassword + ", " + sNewPassword1 + ", " + sNewPassword2);

                if(sOldPassword.isEmpty() || sNewPassword1.isEmpty() || sNewPassword2.isEmpty()){
                    Toast.makeText(getActivity(), "Alle feltene må fylles ut", Toast.LENGTH_SHORT).show();
                }

                else {
                    class ChangePassword extends AsyncTask<Void, Void, String> {
                        ProgressDialog pdLoading = new ProgressDialog(getActivity());

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
                            params.put("oldPassword", sOldPassword);
                            params.put("newPassword1", sNewPassword1);
                            params.put("newPassword2", sNewPassword2);

                            //returing the response
                            return requestHandler.sendPostRequest(URL_CHANGE_PASSWORD, params);
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

                                    Toast.makeText(getActivity().getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(getActivity(), "Exception: " + e, Toast.LENGTH_LONG).show();
                                System.out.println("Exception: " + e);
                            }
                        }
                    }

                    ChangePassword changePassword = new ChangePassword();
                    changePassword.execute();
                }
            }
        });


        return view;
    }

}
