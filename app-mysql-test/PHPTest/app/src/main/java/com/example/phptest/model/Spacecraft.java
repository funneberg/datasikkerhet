package com.example.phptest.model;

public class Spacecraft {
    private int id;
    private String name;

    public Spacecraft(int id, String name) {
        this.id = id;
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }
}
