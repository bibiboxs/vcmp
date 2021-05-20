# 《VC-MP中文输出套件》使用说明&版权声明



> **VC-MP中文输出套件，是由MP-Gamer.Com开发的VC-MP服务端套件，以十分简单高效的方式，实现对VC-MP的服务器输出汉化，未来可能会实现更多功能（如中文输入）。**

> **开发人员：**bbbb & Ctone

> MP-Gamer.Com

---

### 如何使用：

1. 将本文件夹内所有**文件、文件夹**直接放入服务器目录；

2. 在服务端配置文件（server.cfg）中，添加 `plugins -> sockets04rel32`配置项，同时将所有插件+服务端程序的bit改为32（因为该套件要求必须在32位服务端运行）；

3. 在服务端主要脚本中，自行添加（或覆盖）以下内容（API）：

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
   		需要注意，上行内容更多是为了示例，可以不必添加
   		可以自行根据服务器需要，在onPlayerChat中，
   
   		使用：CNInputManager_Message_Label( string ) 或
   			CNInputManager_MessagePlayer_Label( string, player )
   			
   		两种方法来进行自定义玩家聊天输出，这个效果与VC-MP内置的Message基本相同（仅输出英文）
   	*/
   ```

4. 在服务端Client脚本中，自行添加（或覆盖）以下内容（API）：

   ```squirrel
   任意位置 ->
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

**至此，你的服务端已经成功安装中文套件，如果正确安装，则不会出现其他问题。**

---

### 具体使用&相关API

安装套件完成后，你应该需要一些API来执行操作，具体方式如下：

1. 使用套件相关API对VC-MP内置API进行文本替换（因为中文套件的语法是按照VC-MP无缝编写的，可以直接替换使用）；
2. 确定替换或编写无误后，测试使用。

```squirrel
function CNInputManager_Message( text ) //以中文方式输出内容（支持英文等符号）
    
function CNInputManager_MessagePlayer( text, player ) //以中文方式输出内容给玩家（同上）
    
function CNInputManager_Message_Label( text ) //以英文方式输出内容（不支持中文）
    
function CNInputManager_MessagePlayer_Label( text, player ) //以英文方式输出内容给玩家（同上）
```

**以上公开API足以实现中文、英文的输出功能，使用者可根据服务器情况自行使用。**

---

### 重要补充

- 目前版本暂不支持中文输入，仅支持两种方式（中文、英文）的输出；
- 因为默认的文本文档更多是UTF8等编码，所以可能会遇到明明在服务端修改完中文，但仍然输出看不见的问题，针对此情况，你需要先将**服务端进行备份（特别重要）**，然后尝试修改**服务端脚本**的文本编码（具体修改方式可以百度查询），需要将文本编码修改为ANSI编码，修改完成后，你才可以正确无误的在脚本内填写中文（修改ANSI编码之前，需要将脚本全部复制一遍，等待编码修改后再粘贴进去，不然很容易乱码，不可逆找回）；
- 该套件目前是初始版本，已知可能发生的问题是：英文方式的输出可能会根据分辨率的不同，文字大小及位置有偏差（中文方式的输出不会），该问题如果复现，需要反馈开发人员进行调整尝试解决；
- 因为部分代码原因及保护，使用本套件的服务端必须是32-bit服务端+插件，不支持64-bit的VC-MP服务端；
- 该套件基本使用的是用爱发电方式，所以为了开发权益平衡，服务端套件内置了版权保护及联网信息，请支持开发者，这些信息暂时不可直接修改。

---

### 套件版权声明

《VC-MP中文套件》 服务端+客户端组合内容
由【MP-Gamer.Com】开发及版权所有，包括但不限于UI、字库及贴图、源代码等

请尊重任何原创知识产权，尊重原创内容
更多内容请访问：[MP-Gamer.Com](https://www.mp-gamer.com/)
