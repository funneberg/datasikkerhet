package com.example.datasikkerhetapp.model;

import java.util.ArrayList;

public class Inquiry {

    private int id;
    private boolean user;
    private String inquiry;
    private String reply;
    private ArrayList<Comment> comments;

    public Inquiry(int id, boolean user, String inquiry, ArrayList<Comment> comments) {
        this.id = id;
        this.user = user;
        this.inquiry = inquiry;
        this.comments = comments;
        reply = null;
    }

    public Inquiry(int id, boolean user, String inquiry, ArrayList<Comment> comments, String reply) {
        this.id = id;
        this.user = user;
        this.inquiry = inquiry;
        this.reply = reply;
        this.comments = comments;
    }

    public int getId() {
        return id;
    }

    public boolean isUser() {
        return user;
    }

    public String getInquiry() {
        return inquiry;
    }

    public String getResponse() {
        return reply;
    }

    public ArrayList<Comment> getComments() {
        return comments;
    }
}
