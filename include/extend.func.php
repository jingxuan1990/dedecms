<?php
function litimgurls($imgid = 0)
{
    global $lit_imglist, $dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);

    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");

    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2, $imgid);

    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);

    //返回结果
    return $lit_imglist;
}

// 获取当前父栏目的id
function getParentId($typeid)
{
    global $dsql;
    $dsql->SetQuery("SELECT * FROM #@__arctype WHERE id=$typeid");
    $dsql->Execute();
    $row = $dsql->GetArray();
    return $row['reid'];
}

// 获取当前父栏目的链接，用于list_*.htm
function getParentIdATag($typeid)
{
    global $dsql;
    $dsql->SetQuery("SELECT * FROM #@__arctype WHERE id=$typeid");
    $dsql->Execute();
    $row = $dsql->GetArray();
    $reId = $row['reid'];
    $title = $row['typename'];
    $ret = "<a href='plus/list.php?tid=" . $reId . "' title=" . $title . ">" . $title . "</a>";
    return $ret;
}

//获取文档的父栏目的父栏目的链接地址
function GetParentByDocId($docId)
{
    global $dsql;
    $row = $dsql->GetOne("SELECT * FROM #@__archives where id=$docId");
    $typeId = $row['typeid'];
    $row = $dsql->GetOne("SELECT * FROM  #@__arctype WHERE id= $typeId");
    $aTag = "<a href='" . $GLOBALS['cfg_cmspath'] . "/plus/list.php?tid=" . $row['reid'] . "' title='最新资讯文章'>最新资讯文章</a>";
    return $aTag;
}

// 获取当前文档的关键字
function getKeyWordsByDocId($docId)
{
    global $dsql;
    $dsql->SetQuery("SELECT * FROM #@__archives WHERE id=$docId");
    $dsql->Execute();
    $row = $dsql->GetArray();
    $keywords = $row['keywords'];

    $output = '';
    if (!empty($keywords)) {
        foreach (explode(",", $keywords) as $keyword) {
            $searchUrl = "search.php?channeltype=1&keyword=" . $keyword;
            $output .= "<a target='_blank' href=\"$searchUrl\">" . $keyword . "</a>";
        }
    }
    return $output;
}

// 获取文章的内容
function getContentByDocId($docId)
{
    global $dsql;
    $dsql->SetQuery("SELECT * FROM #@__addonarticle WHERE aid=$docId");
    $dsql->Execute();
    $row = $dsql->GetArray();
    $body = $row['body'];
    return $body;
}

function GetCurUrl()
{
    if (!empty($_SERVER['REQUEST_URI'])) {
        $nowurl = $_SERVER['REQUEST_URI'];
        $nowurls = explode('?', $nowurl);
        $nowurl = $nowurls[0];
    } else {
        $nowurl = $_SERVER['PHP_SELF'];
    }
    return $nowurl;
}