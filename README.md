# mudfy3
fy3 via MudPHP

## 什么是MUD
MUD，即泥巴，Multi-User Dungeon，即目前网络游戏（端游+手游+页游）的鼻祖，即文字网络游戏。或许有些朋友没有听过MUD，没关系，这是上个世纪的产物，目前几乎都已经灭绝了。google上面资料一大堆，如果你有兴趣了解，可以通过网上资料来补充这方面的知识。

## 项目介绍
参考源为官方风云3的MUDLIB，编程语言PHP7，通信框架用了WorkerMan。
## 项目状态
停止。

## 更新记录：

2018-4-19
1. 新用户注册
2. 老用户登录
3. hp,score,look,go,fight,kill,quit命令
3. 战斗
4. 死亡
5. 昏迷
6. NPC基础机构
7. 物品基础结构
8. 武器装备

2018-5-22
1. 复活已完成，死亡惩罚。
2. 食物和容器完成。
3. 普通技能以及特殊技能框架实现，详细的技能设定会按地图来完成。
4. 门派以及拜师框架实现，详细的门派设定会按地图来完成。
5. condition的功能实现。
6. NPC chat_msg以及chat_combat_msg实现，允许非战斗状态下的random_move以及战斗状态下的autopfm。
7. abandon,give,drop,say,ask,chat,new,exert,learn,study,exercise,respirate,mediatate,dazuo,buy等命令实现。
8. 商贩功能实现，可以向npc买东西。
9. 钱币功能实现。
10. 场景内door的实现。
11. 尸体处理。
12. 场景自动刷新。
13. 留言板功能。
14. 发呆机制，超时自动退出游戏。
15. 地狱地图完成。
16. 部分风云城地图完成。

2019-8-14
1. 计划中的put,follow,alert等命令已经完成
2. TASK基本功能完成。
3. QUEST基本功能完成。
4. 当铺完成。
5. 银行完成。
6. 战斗perform完成。

## 运行截图：
![image](https://github.com/tiandi79/mudfy3/assets/12792708/140b2e83-af1e-481a-9e00-ea1a3969293f)
![image](https://github.com/tiandi79/mudfy3/assets/12792708/928c18b4-bc44-4ca8-9efb-e1a22510c1e7)
![image](https://github.com/tiandi79/mudfy3/assets/12792708/2390d454-60c7-424e-bfec-a9e4a72be7ec)
![image](https://github.com/tiandi79/mudfy3/assets/12792708/41e8b46b-f7ae-4059-9781-28a07375f7e8)

## DEMO：
http://fy3.tiandiyoyo.com/

## 运行
git clone

php mudos.php

打开浏览器，默认地址为:http://127.0.0.1:3333
