package com.example.datasikkerhetapp;

public class Student {

    private String name;
    private String email;
    private String fieldOfStudy;
    private int year;

    public Student(String name, String email, String fieldOfStudy, int year) {
        this.name = name;
        this.email = email;
        this.fieldOfStudy = fieldOfStudy;
        this.year = year;
    }

    public String getName() {
        return name;
    }

    public String getEmail() {
        return email;
    }

    public String getFieldOfStudy() {
        return fieldOfStudy;
    }

    public int getYear() {
        return year;
    }
}
