<?php
/*
*  配置项
*/
/* MudPHP 版本 */
define('MUDPHP', '1.0');
/* Lib 版本 */
define('LIB_VERSION', '1.0');
/* 服务器IP */
define('IP_ADDRESS','0.0.0.0');
/* 服务器端口 */
define('PORT','3333');
/* 最多用户数 */
define('MAX_USERS','5');
/* MUD名称 */
define('MUD_NAME','风云III');
/* 禁止创建新用户 */
define('NEW_USER_LOCK', false);
/* 游戏根目录 */
define('ROOT_DIR', __DIR__.'/');
/* 地图资源路径 */
define('D_DIR', 'd\\');
/* 用户提升至巫师权限密码 */
define('UPGRADE_PASSWORD','s1i3m0s1');
/* 异常出错 */
define('SYS_ERR', '你发现事情不大对了，但是又说不上来。');
/* 文本帮助文档目录 */
define('HELP_DIR', ROOT_DIR .'doc/help/');
/* 技能目录 */
define('SKILL_D', '\daemon\skill\\');
/* condition目录 */
define('CONDITION_D', '\daemon\condition\\');
/* 门派技能目录 */
define('CLASS_D', '\daemon\classd\\');
/* 超时断线时间 */
define('KICKOUT_TIME', 900);
/* 发呆状态 */
define('IDLE_TIME', 180);
/* 战斗是否加经验 */
define('CAN_ADD_EXP_ON_COMBAT', true);
/* 战斗加经验上限 */
define('CAN_ADD_EXP_BEFORE_EXP', 50000);
/* 战斗加经验概率 */
define('CAN_ADD_EXP_RATE', 10);
/* NPC说话的频率，数字越大，频率越低，建议1000。 */
define('NPC_CHAT_RATIO', 1000);
/* NPC执行combat_chat的频率，数字越大，频率越低，建议100。 */
define('NPC_C0MBAT_CHAT', 100);
/* heal_up的频率 */
define('HEAL_UP_RATIO', 60);
/* 场景重置频率 */
define('ROOM_RESET_RATIO', 900);
/* 场景释放频率 */
define('ROOM_CLEANUP_RATIO', 7200);
/* 新手期 */
define('NEW_PERIOD', 3600 * 48);
/* 新手保护经验 */
define('NEW_COMBAT_EXP', 50000);
/* 自动保存 */
define('AUTOSAVE', 600);
/* 此功能暂未开放 */
define('OPENSOON', '此功能暂未开放。');
/* 密码key */
define('PASSWORDKEY', 'CVIDSFXCE5V7');
/* 在线多少时间等于游戏中的1岁，默认2天 */
define('SECOND_PER_AGE', 172800);
/* quest任务上限经验 */
define('MAX_QUEST_EXP', 9999999999);
/* TASK重新分配时间 */
define('TASK_RESPREAD', 7200);
/* TASK重新刷新时间 */
define('TASK_REFRESH', 1800);

/* room */
define('DEATH_ROOM_NO_PEN', 'd/death/wangsi');
define('DEATH_ROOM', 'd/death/gate');
define('START_ROOM', 'd/fy/church');
define('REVIVE_ROOM', 'd/fy/church');
define('PLAYER_START_ROOM', 'd/fy/fqkhotel');

/* combat */
define('TYPE_REGULAR', 0);
define('TYPE_RIPOSTE', 1);
define('TYPE_QUICK', 2);

define('RESULT_DODGE', -1);
define('RESULT_PARRY', -2);
define('RESULT_PROTECT', -3);

define('SKILL_USAGE_ATTACK', 1);
define('SKILL_USAGE_DEFENSE', 2);
define('SKILL_USAGE_MOVE', 3);

/* 测试开关 */
define('TEST_PARRY', false);
define('TEST_NO_DODGE' ,false);

/*
*  libs
*/
use libs\game;
$GAME = new game();
use libs\object;
$OBJECT = new object();
use libs\gameskills;
$GAMESKILLS = new gameskills();
use libs\conn;
$DEFAULT_CONN = new conn(); 
use libs\conditions;
$CONDITIONS = new conditions(); 

/*
*  加载守护进程
*/
use adm\daemons\chinesed;
$CHINESE_D = new chinesed();
use adm\daemons\logind;
$LOGIN_D = new logind();
use adm\daemons\whod;
$WHO_D = new whod();
use adm\daemons\natured;
$NATURE_D = new natured();
use adm\daemons\updated;
$UPDATE_D = new updated();
use adm\daemons\chard;
$CHAR_D = new chard();
use adm\daemons\race\human;
$HUMAN_RACE = new human(); 
use adm\daemons\combatd;
$COMBAT_D = new combatd();
use adm\daemons\rankd;
$RANK_D = new rankd();
use adm\daemons\fingerd;
$FINGER_D = new fingerd();
use adm\daemons\questd;
$QUEST_D = new questd();
use adm\daemons\taskd;
$TASK_D = new taskd();
use adm\daemons\crond;
$CRON_D = new crond();


/*
*  user命令
*/
use cmds\usr\uptime;
$UPTIME_CMD = new uptime();
use cmds\usr\hp;
$HP_CMD = new hp();
use cmds\usr\who;
$WHO_CMD = new who();
use cmds\usr\quit;
$QUIT_CMD = new quit();
use cmds\usr\help;
$HELP_CMD = new help();
use cmds\usr\score;
$SCORE_CMD = new score();
use cmds\usr\upgrade;
$UPGRADE_CMD = new upgrade();
use cmds\usr\inventory;
$INVENTORY_CMD = new inventory();
use cmds\usr\skills;
$SKILLS_CMD = new skills();
use cmds\usr\save;
$SAVE_CMD = new save();
use cmds\usr\alias;
$ALIAS_CMD = new alias();
use cmds\usr\finger;
$FINGER_CMD = new finger();
use cmds\usr\quest;
$QUEST_CMD = new quest();


/*
*  std命令
*
*/
use cmds\std\look;
$LOOK_CMD = new look();
use cmds\std\go;
$GO_CMD = new go();
use cmds\std\fight;
$FIGHT_CMD = new fight();
use cmds\std\kill;
$KILL_CMD = new kill();
use cmds\std\get;
$GET_CMD = new get();
use cmds\std\put;
$PUT_CMD = new put();
use cmds\std\drop;
$DROP_CMD = new drop();
use cmds\std\wield;
$WIELD_CMD = new wield();
use cmds\std\unwield;
$UNWIELD_CMD = new unwield();
use cmds\std\wear;
$WEAR_CMD = new wear();
use cmds\std\remove;
$REMOVE_CMD = new remove();
use cmds\std\study;
$STUDY_CMD = new study();
use cmds\std\enable;
$ENABLE_CMD = new enable();
use cmds\std\apprentice;
$APPRENTICE_CMD = new apprentice();
use cmds\std\recruit;
$RECRUIT_CMD = new recruit();
use cmds\std\learn;
$LEARN_CMD = new learn();
use cmds\std\buy;
$BUY_CMD = new buy();
use cmds\std\dazuo;
$DAZUO_CMD = new dazuo();
use cmds\std\exercise;
$EXERCISE_CMD = new exercise();
use cmds\std\meditate;
$MEDITATE_CMD = new meditate();
use cmds\std\respirate;
$RESPIRATE_CMD = new respirate();
use cmds\std\perform;
$PERFORM_CMD = new perform();
use cmds\std\exert;
$EXERT_CMD = new exert();
use cmds\std\give;
$GIVE_CMD = new give();
use cmds\std\ask;
$ASK_CMD = new ask();
use cmds\std\say;
$SAY_CMD = new say();
use cmds\std\abandon;
$ABANDON_CMD = new abandon();
use cmds\std\cast;
$CAST_CMD = new cast();
use cmds\std\follow;
$FOLLOW_CMD = new follow();
use cmds\std\alert;
$ALERT_CMD = new alert();
use cmds\std\enforce;
$ENFORCE_CMD = new enforce();
use cmds\std\enchant;
$ENCHANT_CMD = new enchant();
use cmds\std\practice;
$PRACTICE_CMD = new practice();
use cmds\std\task;
$TASK_CMD = new task();
use cmds\std\locate;
$LOCATE_CMD = new locate();

/*
*  wiz命令
*
*/
use cmds\wiz\uids;
$UIDS_CMD = new uids();
use cmds\wiz\oids;
$OIDS_CMD = new oids();
use cmds\wiz\full;
$FULL_CMD = new full();
use cmds\wiz\smash;
$SMASH_CMD = new smash();
use cmds\wiz\update;
$UPDATE_CMD = new update();
use cmds\wiz\ggoto;
$GGOTO_CMD = new ggoto();
use cmds\wiz\call;
$CALL_CMD = new call();
use cmds\wiz\cclone;
$CCLONE_CMD = new cclone();
use cmds\wiz\shutdown;
$SHUTDOWN_CMD = new shutdown();
use cmds\wiz\summon;
$SUMMON_CMD = new summon();
use cmds\wiz\halt;
$HALT_CMD = new halt();