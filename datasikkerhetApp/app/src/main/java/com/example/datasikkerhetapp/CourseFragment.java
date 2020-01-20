package com.example.datasikkerhetapp;


import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.fragment.app.Fragment;

public class CourseFragment extends Fragment {

    private TextView tv;

    public CourseFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_course, container, false);

        String id = getArguments().getString("ID");
        String name = getArguments().getString("Course");

        String course = id + " " + name;

        tv = view.findViewById(R.id.txtCourseName);

        tv.setText(course);

        return view;
    }

}
