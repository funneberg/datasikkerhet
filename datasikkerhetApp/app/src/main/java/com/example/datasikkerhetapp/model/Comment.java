package com.example.datasikkerhetapp.model;

public class Comment {

    private Person sender;
    private int parentCommentID;
    private String comment;

    public Comment(Person sender, int parentCommentID, String comment) {
        this.sender = sender;
        this.parentCommentID = parentCommentID;
        this.comment = comment;
    }

    public Comment(int parentCommentID, String comment) {
        sender = null;
        this.parentCommentID = parentCommentID;
        this.comment = comment;
    }


}
