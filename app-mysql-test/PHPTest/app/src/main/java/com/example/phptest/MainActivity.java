package com.example.phptest;

import android.app.FragmentManager;
import android.graphics.Color;
import android.os.Bundle;
import android.util.TypedValue;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.FragmentTransaction;

import com.example.phptest.model.Course;
import com.example.phptest.model.Spacecraft;
import com.example.phptest.mysql.Downloader;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {

    //spacecraft_select.php is our pho code. It is contained in
    //a folder called `android`. : `C:wampwwwandroidspacecraft_select.php`

    private static final String urlAddress="http://192.168.4.108/datasikkerhet/test/getcourses.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        //setSupportActionBar(toolbar);

        final ListView lv= findViewById(R.id.lv);

        Button btn = findViewById(R.id.btn);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Downloader d=new Downloader(MainActivity.this,urlAddress,lv);
                d.execute();
            }
        });
    }

    public void populateList(ArrayList<Course> courses) {
        System.out.println("Fyller view med spacecrafts!!!");

        LinearLayout linearLayout = findViewById(R.id.courseList);

        linearLayout.removeAllViews();

        StringBuilder sb = new StringBuilder();

        System.out.println("Famous last words...");

        for (int i = 0; i < courses.size(); i++) {
            sb.append(i).append(" ");
        }

        System.out.println("xD: " + courses.size());

        for (Course course : courses) {

            System.out.println("Fungerar ditta?");

            CardView cardView = new CardView(this);

            LinearLayout.LayoutParams layoutParams = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            );

            cardView.setLayoutParams(layoutParams);
            cardView.setRadius(9);
            cardView.setContentPadding(15,30,15,30);
            cardView.setCardBackgroundColor(Color.LTGRAY);
            cardView.setMaxCardElevation(5);
            cardView.setCardElevation(2);
            cardView.setUseCompatPadding(true);

            TextView textView = new TextView(this);
            textView.setLayoutParams(layoutParams);
            String str = course.getCode() + " " + course.getName();
            textView.setText(str);
            textView.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 22);
            textView.setTextColor(Color.BLACK);

            cardView.addView(textView);

            linearLayout.addView(cardView);

            System.out.println("Liste | " + course.getCode() + " - " + course.getName());

        }
    }
}
