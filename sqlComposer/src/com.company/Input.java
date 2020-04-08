package com.company;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;

/**
 * Created by lament on 22.06.2017.
 */
public class Input {

    static BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));

    public static ArrayList<String> dataInput() throws IOException {

        ArrayList<String> resultList = new ArrayList<>();
        boolean[] flag = {false, false};
        String[] assurance = {"", ""};


        do {
            //Получаем входные данные с клавы
            do {
                System.out.println("Please enter operator. Available operators: insert");
                resultList.add (reader.readLine());

                if (!resultList.get(0).toLowerCase().equals("insert") /*|| !resultList.get(0).toLowerCase().equals("update")*/) {
                    System.out.println("Incorrect operator. Try again.");
                    resultList.remove(0);
                }
                else
                    flag[0] = true;
            } while (flag[0] == false);
            System.out.println("Please enter table name:");
            resultList.add(reader.readLine());

            System.out.println("Please enter fields, quantity of fields and values should be same:");
            resultList.add(reader.readLine());
            System.out.println("Enter string in this format: value,value,value");
            System.out.println("If you want random value use: rand_text (for random string), rand_int (for random int up to 1000), rand_email (for random email), rand_hex (for HEX)");
            System.out.println("You could use this sign rand_text///30 to receive random string with 30 chars length");
            resultList.add(reader.readLine());

            if (Separators.fieldsSeparator(resultList.get(2)).size() != Separators.valuesSeparator(resultList.get(3)).size())
            {
                System.out.println("Incorrect input. Exiting...");
                System.exit(0);
            }

            //Проверяем корректность данных
            System.out.println("Check your request");
            for (int i = 0; i < resultList.size(); i++)
            {
                if (i == 0) {
                    System.out.println(resultList.get(i) + " into");
                }
                else if (i == 2){
                    System.out.println(resultList.get(i));
                    System.out.println("values");
                }
                else
                    System.out.println(resultList.get(i));
            }

            System.out.println("Are you sure? y/n");
            assurance[0] = reader.readLine();
            if (!(assurance[0].toLowerCase().equals("y") || assurance[0].toLowerCase().equals("n")))
            {
                System.out.println("Incorrect input. Exiting...");
                System.exit(0);
            }
            if (assurance[0].toLowerCase().equals("n")) {
                resultList.clear();
                System.out.println("Will you proceed? y/n");
                assurance[1] = reader.readLine();
                if (!(assurance[1].toLowerCase().equals("y") || assurance[1].toLowerCase().equals("n")))
                {
                    System.out.println("Incorrect input. Exiting...");
                    System.exit(0);
                }
                if (assurance[1].toLowerCase().equals("n"))
                    System.exit(0);
            }
            else
                flag[1] = true;
        } while (flag[1] == false);

        return resultList;
    }

    public static int quantityInput()
    {
        int quantity = 0;
        System.out.println("Please enter number of lines:");
        try {
            quantity = Integer.parseInt(reader.readLine());
        } catch (IOException e) {
            e.printStackTrace();
        }
        return quantity;
    }
}
