package com.example.datasikkerhetapp.model;

public class Comment {

    private int id;
    private String comment;
    private boolean user;

    public Comment(int id, String comment, boolean user) {
        this.id = id;
        this.user = user;
        this.comment = comment;
    }

    public int getId() {
        return id;
    }

    public String getComment() {
        return comment;
    }

    public boolean isUser() {
        return user;
    }
}
