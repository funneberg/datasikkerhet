package com.example.datasikkerhetapp.model;

public class Course {

    private static int counter = 0;

    private int id;
    private String code;
    private String name;

    public Course(String code, String name) {
        this.id = counter++;
        this.code = code;
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public String getCode() {
        return code;
    }

    public String getName() {
        return name;
    }

    @Override
    public String toString() {
        return code + " " + name;
    }

}
