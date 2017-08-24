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

// 获取父栏目的id
function getParentId($typeid)
{
    global $dsql;
    $dsql->SetQuery("SELECT * FROM #@__arctype WHERE id=$typeid");
    $dsql->Execute();
    $row = $dsql->GetArray();
    return $row['reid'];
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