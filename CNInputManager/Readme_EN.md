# "VC-MP Chinese Output Package" Instructions & Copyright Statement



> **VC-MP Chinese output kit is a VC-MP server kit developed by MP-Gamer.Com. It can realize the Chinese output of VC-MP server in a very simple and efficient way. More functions may be realized in the future (Such as Chinese input). **

> **Developer: **bbbb & Ctone

> MP-Gamer.Com

---

### how to use:

1. Put all **files and folders** in this folder directly into the server directory;

2. In the server configuration file (server.cfg), add the `plugins -> sockets04rel32` configuration item, and at the same time change the bit of all plug-ins + server program to 32 (because the kit must run on a 32-bit server) ；

3. In the main script of the server, add (or overwrite) the following content (API) by yourself:

   ```squirrel
   onScriptLoad ->
   dofile("CNInputManager/CNInputManager.nut");
   CNInputManager_onScriptLoad();
   
   onPlayerJoin ->
   CNInputManager_onPlayerJoin( player );
   
   onPlayerPart ->
   CNInputManager_onPlayerPart( player );
   
   onPlayerRequestClass ->
   CNInputManager_onPlayerRequestClass( player );
   
   onPlayerChat ->
   CNInputManager_onPlayerChat( player, text );
   /*
   It should be noted that the upstream content is more for example, you don’t need to add
   According to the needs of the server, in onPlayerChat,
   
   Use: CNInputManager_Message_Label( string) or
   CNInputManager_MessagePlayer_Label( string, player)
   To
   Two methods to customize player chat output, this effect is basically the same as the built-in Message of VC-MP (only English output)
   */
   ```

4. In the server Client script, add (or overwrite) the following content (API) by yourself:

   ```squirrel
   Anywhere ->
       include( "CNInputManager_mem.nut" );
   
   Script::ScriptLoad() ->
   C_CNInputManager_onScriptLoad();
   
   Script::ScriptProcess() ->
       C_CNInputManager_onScriptProcess();
   
   GUI::GameResize(width, height) ->
       C_CNInputManager_onGameResize(width, height);
   
   Server::ServerData(stream) ->
       local StreamReadInt = stream.ReadInt(),
   StreamReadString = stream.ReadString();
   
   C_CNInputManager_onServerData(StreamReadInt, StreamReadString);
   
   KeyBind::OnDown(key) ->
   C_CNInputManager_onDown(key);
   ```

**At this point, your server has successfully installed the Chinese package. If it is installed correctly, no other problems will occur. **

---

### Specific use & related API

After installing the kit, you should need some APIs to perform operations, as follows:

1. Use the kit-related API to replace the VC-MP built-in API (because the grammar of the Chinese kit is seamlessly written in accordance with VC-MP, you can directly replace it);
2. After confirming that the replacement or writing is correct, test and use.

```squirrel
function CNInputManager_Message( text) //Output content in Chinese (support English and other symbols)
    
function CNInputManager_MessagePlayer( text, player) //Output content to the player in Chinese (same as above)
    
function CNInputManager_Message_Label( text) //Output content in English (Chinese is not supported)
    
function CNInputManager_MessagePlayer_Label( text, player) //Output content to the player in English (same as above)
```

**The above public API is sufficient to realize the output function of Chinese and English, and users can use it according to the situation of the server. **

---

### Important supplement

-The current version does not support Chinese input for the time being, and only supports output in two ways (Chinese and English);
-Because the default text documents are more encodings such as UTF8, so you may encounter the problem of invisible output after you have modified the Chinese on the server side. In this case, you need to back up the ** server side (especially Important)**, and then try to modify the text encoding of the **server script** (you can query Baidu for the specific modification method). You need to modify the text encoding to ANSI encoding. After the modification is completed, you can fill in the script correctly. Chinese (before modifying the ANSI code, you need to copy all the scripts, wait for the code to be modified and then paste it in, otherwise it will be easy to mess up and irreversibly retrieved);
-The package is currently the initial version. The known problems that may occur are: English output may vary depending on the resolution, and the text size and position may deviate (Chinese output will not). If the problem recurs, it is necessary Feedback developers to make adjustments and try to solve them;
-Due to some code reasons and protection, the server using this kit must be a 32-bit server + plug-in, and 64-bit VC-MP server is not supported;
-The kit basically uses the love power generation method, so in order to develop the balance of rights, the server kit has built-in copyright protection and networking information. Please support the developer. This information cannot be directly modified for the time being.

---

### Package copyright statement

"VC-MP Chinese Package" server + client combination content
Developed and copyrighted by [MP-Gamer.Com], including but not limited to UI, fonts and textures, source code, etc.

Please respect any original intellectual property rights and original content
For more information, please visit: [MP-Gamer.Com](https://www.mp-gamer.com/)
