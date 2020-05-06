package com.example.phptest.model;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;
import android.widget.Toast;

import com.example.phptest.R;

import java.util.ArrayList;

public class CustomAdapter extends BaseAdapter {

    Context c;
    ArrayList<Spacecraft> spacecrafts;
    LayoutInflater inflater;

    public CustomAdapter(Context c, ArrayList<Spacecraft> spacecrafts) {
        this.c = c;
        this.spacecrafts = spacecrafts;

        //INITIALIE
        inflater= (LayoutInflater) c.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return spacecrafts.size();
    }

    @Override
    public Object getItem(int position) {
        return spacecrafts.get(position);
    }

    @Override
    public long getItemId(int position) {
        return spacecrafts.get(position).getId();
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        if(convertView==null)
        {
            convertView=inflater.inflate(R.layout.model,parent,false);
        }

        TextView idTxt= (TextView) convertView.findViewById(R.id.idTxt);
        TextView nameTxt= (TextView) convertView.findViewById(R.id.nameTxt);

        System.out.println("SpacecraftsName: " + spacecrafts.get(position).getName());

        String id = Integer.toString(spacecrafts.get(position).getId());
        String name = spacecrafts.get(position).getName();

        idTxt.setText(id);
        nameTxt.setText(name);

        //ITEM CLICKS
        convertView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(c,spacecrafts.get(position).getName(),Toast.LENGTH_SHORT).show();
            }
        });

        return convertView;
    }
}
