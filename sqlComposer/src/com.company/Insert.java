package com.company;

import java.util.ArrayList;
import java.util.Random;

/**
 * Created by lament on 21.06.2017.
 */
public class Insert {

    public static final String chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    public static final String nums = "1234567890";
    public static final String hex = "ABCDEF1234567890";

    public static ArrayList<String> Insert(String operator, String tableName, ArrayList<String> separatedFields, ArrayList<String[]> separatedValues)
    {
        ArrayList<String> resultList = new ArrayList<>();
        int quantity = Input.quantityInput();
        String temp = "";

        resultList.add(operator + " INTO " + "`" +tableName + "`");             //0
        for (int i = 0; i < separatedFields.size(); i++) {
            if (i == separatedFields.size()-1)
                temp = temp + "`" + separatedFields.get(i) + "`";
            else
                temp = temp + "`" + separatedFields.get(i) + "`" + ",";
        }
        resultList.add("(" + temp + ")");                                       //1
        resultList.add("VALUES");                                               //2

        for (int i = 0; i < quantity; i++)
        {
            if(i == quantity-1)
                resultList.add(valueStringCreator(separatedValues,true));
            else
                resultList.add(valueStringCreator(separatedValues));
        }

        return resultList;
    }

    public static String randomString(String chars, int length) {
        Random rand = new Random();
        StringBuilder buf = new StringBuilder();
        for (int i=0; i<length; i++) {
            buf.append(chars.charAt(rand.nextInt(chars.length())));
        }
        return buf.toString();
    }

    public static String valueStringCreator (ArrayList<String[]> separatedValues)
    {
        String result = "(";
        for (int i = 0; i < separatedValues.size(); i++)
        {
            String[] temp = separatedValues.get(i);
            if (temp[0].equals("rand_text")){
                result = result + "'" + randomString(chars, Integer.parseInt(temp[1])) + "'";
            } else if (temp[0].equals("rand_int")){
                result = result + "'" + randomString(nums, Integer.parseInt(temp[1])) + "'";
            } else if (temp[0].equals("rand_email")){
                result = result + "'" + randomString(chars, Integer.parseInt(temp[1])) + "@test.ru'";
            } else if (temp[0].equals("rand_hex")){
                result = result + "'" + randomString(hex, Integer.parseInt(temp[1])) + "'";
            } else {
                result = result + "'" + temp[0] + "'";
            }
            if (i == separatedValues.size() - 1)
                result = result + "),";
            else
                result = result + ",";
        }
        return result;
    }

    public static String valueStringCreator (ArrayList<String[]> separatedValues, boolean is_last)
    {
        String result = "(";
        for (int i = 0; i < separatedValues.size(); i++)
        {
            String[] temp = separatedValues.get(i);
            if (temp[0].equals("rand_text")){
                result = result + "'" + randomString(chars, Integer.parseInt(temp[1])) + "'";
            } else if (temp[0].equals("rand_int")){
                result = result + "'" + randomString(nums, Integer.parseInt(temp[1])) + "'";
            } else if (temp[0].equals("rand_email")){
                result = result + "'" + randomString(chars, Integer.parseInt(temp[1])) + "@test.ru'";
            } else if (temp[0].equals("rand_hex")){
                result = result + "'" + randomString(hex, Integer.parseInt(temp[1])) + "'";
            } else {
                result = result + "'" + temp[0] + "'";
            }
            if (i == separatedValues.size() - 1)
                result = result + ");";
            else
                result = result + ",";
        }
        return result;
    }
}
