package com.example.datasikkerhetapp.model;

public class Course {

    private String code;
    private String name;
    private Lecturer lecturer;

    public Course(String code, String name) {
        this.code = code;
        this.name = name;
        lecturer = null;
    }

    public String getCode() {
        return code;
    }

    public String getName() {
        return name;
    }

    public Lecturer getLecturer() {
        return lecturer;
    }

    public void setLecturer(Lecturer lecturer) {
        this.lecturer = lecturer;
    }

    @Override
    public String toString() {
        return code + " " + name;
    }

}
