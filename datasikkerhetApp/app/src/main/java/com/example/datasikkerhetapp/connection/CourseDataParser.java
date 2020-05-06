package com.example.datasikkerhetapp.connection;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.widget.Toast;


import com.example.datasikkerhetapp.MainActivity;
import com.example.datasikkerhetapp.model.Course;
import com.example.datasikkerhetapp.model.Lecturer;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class CourseDataParser extends AsyncTask<Void,Void,Integer>{

    Context c;
    String jsonData;

    ProgressDialog pd;
    ArrayList<Course> courses =new ArrayList<>();

    public CourseDataParser(Context c, String jsonData) {
        this.c = c;
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
            MainActivity ma = (MainActivity) c;
            ma.setCourses(courses);

            ma.showCourselist();
        }
    }

    private int parseData() {
        try {
            JSONArray ja=new JSONArray(jsonData);
            JSONObject jo;

            courses.clear();

            for(int i=0;i<ja.length();i++) {
                jo=ja.getJSONObject(i);

                String code=jo.getString("emnekode");
                String name=jo.getString("emnenavn");

                String lecturerName;
                String lecturerEmail;
                String lecturerPhoto;

                lecturerName = jo.getString("navn");
                lecturerEmail = jo.getString("foreleser");
                lecturerPhoto = jo.getString("bilde");

                Course course = new Course(code, name, new Lecturer(lecturerName, lecturerEmail, lecturerPhoto));

                courses.add(course);

            }

            return 1;

        }
        catch (JSONException e) {
            e.printStackTrace();
        }

        return 0;
    }
}
