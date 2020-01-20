package com.example.datasikkerhetapp;


import android.graphics.Color;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.LinearLayout.LayoutParams;
import android.widget.RelativeLayout;
import android.widget.Space;
import android.widget.TextView;

import java.util.ArrayList;

public class CourseListFragment extends Fragment {

    private LinearLayout linearLayout;

    public CourseListFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_course_list, container, false);

        linearLayout = view.findViewById(R.id.courseList);

        //Testdata:
        ArrayList<Course> courses = new ArrayList<>();
        courses.add(new Course("ITF10619", "Programmering 2"));
        courses.add(new Course("ITF25019", "Datasikkerhet i utvikling og drift"));
        courses.add(new Course("ITF20119", "Rammeverk"));

        for (Course aCourse : courses) {
            /*
            CardView cardView = new CardView(getActivity());

            TextView textView = new TextView(getActivity());

            cardView.setLayoutParams(new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            ));

            cardView.setPadding(2,2,2,2);

            textView.setText(aCourse);
            cardView.addView(textView);
            linearLayout.addView(cardView);

             */

            CardView cardView = new CardView(getActivity());

            LayoutParams layoutParams = new LayoutParams(
                    LayoutParams.WRAP_CONTENT,
                    LayoutParams.WRAP_CONTENT
            );

            cardView.setLayoutParams(layoutParams);
            cardView.setRadius(9);
            cardView.setContentPadding(15,15,15,15);
            cardView.setCardBackgroundColor(Color.BLACK);
            cardView.setMaxCardElevation(15);
            cardView.setCardElevation(9);

            TextView textView = new TextView(getActivity());
            textView.setLayoutParams(layoutParams);
            textView.setText(aCourse.toString());
            textView.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 30);
            textView.setTextColor(Color.GREEN);

            cardView.addView(textView);

            linearLayout.addView(cardView);

            /*
            View space = new View(getActivity());
            view.setLayoutParams(new LayoutParams(
                    LayoutParams.MATCH_PARENT,
                    1
            ));

            linearLayout.addView(space);

             */

        }

        return view;
    }

    /*
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);


    }
     */
}
