package com.company;

import java.io.IOException;
import java.util.ArrayList;

public class Main {

    public static void main(String[] args) throws IOException {
        // write your code here

        ArrayList<String> resultList;
        ArrayList<String> inputList = Input.dataInput();

        if (inputList.get(0).toLowerCase().equals("insert"))
        {
            resultList = Insert.Insert(inputList.get(0).toUpperCase(), inputList.get(1), Separators.fieldsSeparator(inputList.get(2)), Separators.valuesSeparator(inputList.get(3)));

            for (int i = 0; i < resultList.size(); i++)
            {
                System.out.println(resultList.get(i));
            }
        }
            /*if (operator.toLowerCase().equals("update"))
            {

            }*/







    }

}
