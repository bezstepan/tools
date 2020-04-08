package com.company;

import java.util.ArrayList;

/**
 * Created by lament on 22.06.2017.
 */
public class Separators {

    public static ArrayList<String> fieldsSeparator(String fields)
    {
        ArrayList<String> separatedFields = new ArrayList<>();
        String[] split = fields.split(",");
        for (int i=0; i < split.length; i++)
        {
            separatedFields.add(split[i].trim());
        }
        return separatedFields;
    }

    public static ArrayList<String[]> valuesSeparator(String values)
    {
        ArrayList<String[]> separatedValues = new ArrayList<>();
        String[] split = values.split(",");
        for (int i=0; i < split.length; i++)
        {
            if(!split[i].contains("///"))
            {
                split[i] = split[i].trim() + "///20";
            }
            String[] newSplit = split[i].split("///");
            separatedValues.add(newSplit);
        }
        return separatedValues;
    }
}
