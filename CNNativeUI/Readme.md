This component has not written any help documents, please read the code based on your own experience, and use translation tools to try to understand the Chinese content, and finally put it on your server

#A test
```
curClass = GameCMenuUIs.Casino;	
if( active )
{
  curClass = CNNativeUI_Create("Casino", "欢迎光临：迈阿密风云娱乐城！");

  GameCMenuUIs.Casino = curClass;
  GameCMenuUIs.Casino.AddItem("[#93ff52]#玩法：迈阿密每日彩票#", "每晚指定游戏时间开奖，购买后退出游戏失效");
  GameCMenuUIs.Casino.AddItem("欲购号码（1~7）：", "输入指定号码购买，每注奖金￥1000", CNNATIVEUI_TYPE_EDITBOX, "7");
  GameCMenuUIs.Casino.AddItem("欲购倍数（1~1000/回车）：", "输入指定倍数进行购买，中奖奖金会翻倍", CNNATIVEUI_TYPE_EDITBOX, "1");
  GameCMenuUIs.Casino.AddItem("[#52e5ff]确认购买此号码", "点击按钮，立即购买此号码，退出游戏失效", CNNATIVEUI_TYPE_BUTTON, "$0", Colour(255, 83, 184, 255));
  GameCMenuUIs.Casino.AddItem("", "");

  GameCMenuUIs.Casino.AddItem("[#93ff52]#玩法：迈阿密灵魂摇奖#", "每晚指定游戏时间开奖，购买后退出游戏失效");
  GameCMenuUIs.Casino.AddItem("当前随机奖项：[#ff8352]等待购买", "此处仅供显示开奖内容，请先在下方购买");
  GameCMenuUIs.Casino.AddItem("[#52e5ff]确认开始随机摇奖", "点击按钮，立即开始随机摇奖", CNNATIVEUI_TYPE_BUTTON, "$0", Colour(255, 83, 184, 255));
}else{
  GameCMenuUIs.Casino = null;
}
```
This is just a simple example, just to provide some help, you can use it in this way after the correct installation
