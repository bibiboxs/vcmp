# CNInputManager VC-MP 0.4 Chinese chat suite

> This is a chat suite that supports 04rel006 and above, for VC-MP 0.4 server, supports 3700+ Chinese, English and symbol characters

> Development group: MP-Gamer.Com; script: bbbb; creative contribution: Ctone

---

## Development Ideas

1. Generate 3700+(*.png) format pictures of the specified size (such as 25x25) by manual or batch means, and make them transparent in batches, and change the picture file names to unicode codes;
2. Due to the limitation of the number of VC-MP Stores, all font textures should be packaged into the supported xxx_unp.7z format, and then placed in store\sprites according to the specified format to be used as GUI resource textures;
3. Write a GUI client script to simulate the GUI chat box in the upper left corner -> batch line space -> dynamically generate 45+ transparent texture Sprites in each line for backup.
4. Write server-side scripts and write global replacement methods (Function) so that players can use them seamlessly by replacing Message("") with CNInputManager_Message. The core method of CNInputManager_Message: pass Chinese content according to the script file encoding (ANSI) To the client.
5. The client Chinese master script receives the Chinese character string from the server. It is not possible to split the character string directly to parse it. Because the original squirrel language intelligently splits the single-byte character string, you need to write your own parsing code to detect each Whether each character is a 1-bit or 2-bit byte character (due to the characteristics of Chinese characters, no more than 2 digits), because the traditional single-byte text is always >= 0 after being converted to an integer, it is only necessary to determine whether the `current byte` is> = 0 can be obtained, if >= 0, it is traditional ASNI English or alphanumeric, etc., otherwise it is an "abnormal" double-byte character, and then continue to judge the next byte and connect it;
6. After judging the byte, it cannot be directly converted to string again, because after the string is converted, it becomes a single byte (composed of one byte and one byte), so for a better understanding, it must be converted into N Array strings. Array, to ensure that the value in each array is a real "text".
7. Once you have an array of text strings, you only need to traverse the array, and at the same time prepare dozens of blank textures from a certain line. According to the file naming rules, SetTexture is changed to the Unicode code of the array [Index]. Realize changing the reserved Alpha textures one by one to Png textures with text inside. On the contrary, if there is still space left after the text is written, reset the reserved space to Alpha textures to complete the display.
8. Write the chat simulation logic, that is, the new message is at the bottom. If the message box is full, it will automatically move up (the top one will disappear).
9. Write a string to support the hexadecimal color code HEX, here you need to use the hexadecimal conversion (16 to decimal), and then divide and remove according to the method, modify the current Sprite Color to complete the color code support.
10. Write a timing method on the server or client to simulate the automatic cleaning of the chat content at the bottom every 10 seconds.
11. Because there is no better way to consider Chinese input in the initial stage of the kit, the GUILabel method will be used to simulate English input and output as usual, that is, it is temporarily unable to use Chinese for input. Specific method: On the basis of the transparent prefabrication of each line, the empty text GUILabel of each line is also prefabricated, and the judgment is made on the server side. Only when onPlayerChat chats, use GUILabel transmission, otherwise (Chinese) use the above-mentioned texture method ( To put it simply, there are two display modes reserved for each row, namely, map display and Label display).
