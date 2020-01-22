package com.example.datasikkerhetapp.mysql_connection;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.widget.ListView;
import android.widget.Toast;



import com.example.datasikkerhetapp.CustomAdapter;
import com.example.datasikkerhetapp.model.Course;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class DataParser  extends AsyncTask<Void,Void,Integer>{

    Context c;
    ListView lv;
    String jsonData;

    ProgressDialog pd;
    ArrayList<Course> courses =new ArrayList<>();

    public DataParser(Context c, ListView lv, String jsonData) {
        this.c = c;
        this.lv = lv;
        this.jsonData = jsonData;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();

        pd=new ProgressDialog(c);
        pd.setTitle("Parse");
        pd.setMessage("Parsing...Please wait");
        pd.show();
    }

    @Override
    protected Integer doInBackground(Void... params) {
        return this.parseData();
    }

    @Override
    protected void onPostExecute(Integer result) {
        super.onPostExecute(result);

        pd.dismiss();
        if(result==0)
        {
            Toast.makeText(c,"Unable to parse",Toast.LENGTH_SHORT).show();
        }else {
            //CALL ADAPTER TO BIND DATA
            CustomAdapter adapter=new CustomAdapter(c, courses);
            lv.setAdapter(adapter);
        }
    }

    private int parseData()
    {
        try {
            JSONArray ja=new JSONArray(jsonData);
            JSONObject jo = null;

            courses.clear();
            Course course = null;

            for(int i=0;i<ja.length();i++)
            {
                jo=ja.getJSONObject(i);

                String code=jo.getString("code");
                String name=jo.getString("name");

                course = new Course(code, name);

                courses.add(course);

            }

            return 1;

        } catch (JSONException e) {
            e.printStackTrace();
        }

        return 0;
    }
}
