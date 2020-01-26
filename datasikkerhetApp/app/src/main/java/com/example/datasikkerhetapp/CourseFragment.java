package com.example.datasikkerhetapp;


import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.fragment.app.Fragment;

import com.example.datasikkerhetapp.model.Course;
import com.example.datasikkerhetapp.model.Student;

import java.util.ArrayList;

public class CourseFragment extends Fragment {

    private LinearLayout linearLayout;
    private TextView tv;

    public CourseFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_course, container, false);

        setup(view);

        return view;
    }

    private void setup(View view) {
        linearLayout = view.findViewById(R.id.lecturerLayout);
        Course course = getChosenCourse();

        System.out.println("Testing 123: " + (course.getLecturer() != null) + " " +
                (course.getLecturer() != null ? course.getLecturer().getName() : ""));

        if (course.getLecturer() != null) {
            View lecturerLayout = getLayoutInflater().inflate(R.layout.lecturer_view, linearLayout);
            ImageView imgView = lecturerLayout.findViewById(R.id.imgLecturer);
            TextView nameView = lecturerLayout.findViewById(R.id.lecturerName);
            TextView emailView = lecturerLayout.findViewById(R.id.lecturerEmail);

            nameView.setText(course.getLecturer().getName());
            emailView.setText(course.getLecturer().getEmail());
        }

        Student user = Account.getActiveUser();

        String txtCourse = course.getCode() + " " + course.getName();

        tv = view.findViewById(R.id.txtCourseName);
        tv.setText(txtCourse);
    }

    private Course getChosenCourse() {
        String code = getArguments().getString("Coursecode");
        MainActivity ma = (MainActivity) getActivity();
        ArrayList<Course> courses = ma.getCourses();
        for (Course course : courses) {
            if (course.getCode().equals(code)) {
                return course;
            }
        }
        return null;
    }

}
