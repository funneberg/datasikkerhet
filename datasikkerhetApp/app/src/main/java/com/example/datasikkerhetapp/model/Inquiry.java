package com.example.datasikkerhetapp.model;

import java.util.ArrayList;

public class Inquiry {

    private int id;
    private Student sender;
    private Lecturer reciever;
    private String inquiry;
    private Comment response;
    private ArrayList<Comment> comments;

    public Inquiry(int id, Student sender, Lecturer reciever, String inquiry, ArrayList<Comment> comments) {
        this.id = id;
        this.sender = sender;
        this.reciever = reciever;
        this.inquiry = inquiry;
        this.comments = comments;
        response = null;
    }

    public Inquiry(int id, Student sender, Lecturer reciever, String inquiry, ArrayList<Comment> comments, Comment response) {
        this.id = id;
        this.sender = sender;
        this.reciever = reciever;
        this.inquiry = inquiry;
        this.response = response;
        this.comments = comments;
    }

}
