<?php
/**
 *
    Template Name: 计算器2
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        // End the loop.
        endwhile;
        ?>


<!-- 添加自定义 开始 -->

<div class="entry-content">

<style type="text/css">
    #zhib-daikjisuan .input-group {
        margin-bottom: 15px !important;
    }
    #mianze{
        margin: 10px auto;
        color: #fff;
        padding: 15px 5px;
        background: #666666;
    }
    #mianze p{
     font-size:14px;
      text-align:justify;
    }
    #jisuanji-anj{
      text-align:center;
      padding:10px;
      background:#baa26c;
    }
    #jisuanji-anj a{
      color:#fff;
      font-size:18px;
      font-weight:700;
    }
    .btn a{
      color: #fff !important;
    }
</style>

<style type="text/css" media=print> 
    .noprint{display:none} 
</style>

<script type="text/javascript" charset="utf-8">
    function showLightBox(divId) {
        $("#calculator").lightbox_me({
            centered: true,
            onLoad: function() {

            }
        });
    }
    function closeTuceng(){
       $("#calculator").hide();
    }
</script>

<script>
	// 对网站语言进行判断 开始
    var i18n = {
            calculation: {
                en: 'The calculation may take a long time, continue?',
                'zh-hant': '可能需要点时间进行计算'
            }
        },
    lang = document.getElementsByTagName('html')[0].getAttribute('lang'),
    confirmation = true;
	// 对网站语言进行判断 结束
    function PMT() {
		// 获取各个表单的值 开始
        var cengs = document.getElementById('cengshu').value;
        var kuangd = document.getElementById('kuangdu').value;
        var changd = document.getElementById('changdu').value;
        var shul = document.getElementById('shuliang').value;
        var banzihoud = document.getElementById('banzihoudu').value;
        var pingbankuans = document.getElementById('pingbankuanshu').value;
        var zifuyanseselected =$('#zifuyanse option:selected').val();
        var zuhanyans =document.getElementById('zuhanyanse');
        var zuhanyanseselected=$('#zuhanyanse option:selected').val();
        var fapiaoselected=$('#fapiao option:selected').val();
        var fahuoshijianselected=$('#fahuoshijian option:selected').val();
        var feizhenceshiselected=$('#feizhenceshi option:selected').val();
        var zuhanfugaiselected=$('#zuhanfugai option:selected').val();
        var sum = 0;
        // 获取各个表单的值 结束

		// 检测 如果表单输入的是非数字值 那么计算的结果将会变成0 开始
        if (isNaN(shul) == true) sum = 0;
        if (isNaN(kuangd) == true) sum = 0;
        if (isNaN(changd) == true) sum = 0;
        if (isNaN(cengs) == true) sum = 0;
        if (isNaN(banzihoud) == true) sum = 0;
        if (isNaN(pingbankuans) == true) sum = 0;
        // 检测 如果表单输入的是非数字值 那么计算的结果将会变成0 结束

        // 计算总数 开始
        sum=(cengs*kuangd*changd*shul*banzihoud*pingbankuans)+parseInt(zifuyanseselected)+parseInt(zuhanyanseselected)+parseInt(fapiaoselected)+parseInt(fahuoshijianselected)+parseInt(zuhanfugaiselected)+parseInt(feizhenceshiselected);
        // 计算总数 结束

    // 判断 如果各项指标都填写了，那么把计算结果输出 开始

		// 判断 单纯的整数相乘计算 开始
		if (cengs && kuangd && changd && shul && pingbankuans && zifuyanseselected && banzihoud && fapiaoselected && fahuoshijianselected && zuhanfugaiselected && feizhenceshiselected) {
            return document.getElementById('calSum').value = '￥' + sum;
        }
        // 判断 单纯的整数相乘计算 结束

    // 判断 如果各项指标都填写了，那么把计算结果输出 结束
    }

    // 清空表单内容 开始
    function calClear() {
        document.getElementById('cengshu').value = '';
        document.getElementById('kuangdu').value = '';
        document.getElementById('changdu').value = '';
        document.getElementById('shuliang').value = '';
        document.getElementById('banzihoudu').value = '';
		document.getElementById('pingbankuanshu').value = '';
        document.getElementById('calSum').value = '';
    }
    // 清空表单内容 结束
</script>

<script>
    // 打印控制代码 开始
    function preview(oper) {
        if (oper < 10)
        {
        bdhtml=window.document.body.innerHTML;//获取当前页的html代码 
        sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域 
        eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域 
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html 

        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html 
        window.document.body.innerHTML=prnhtml;
        window.print();
        window.document.body.innerHTML=bdhtml;
        } else {
        window.print();
        }
    }
    // 打印控制代码 结束
</script>

<div class="container">
    <div id="zhib-daikjisuan">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">板子层数</span>
                  <input type="text" class="form-control" id="cengshu" v-model="picked" onchange="PMT();" placeholder="cm" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon2">板子宽度</span>
                  <input type="text" class="form-control" id="kuangdu" v-model="kuang" onchange="PMT();" placeholder="cm" aria-describedby="basic-addon2">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon3">板子长度</span>
                  <input type="text" class="form-control" id="changdu" v-model="chang" onchange="PMT();" placeholder="cm" aria-describedby="basic-addon3">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon4">板子数量</span>
                  <input type="text" class="form-control" id="shuliang" v-model="shuliangss" onchange="PMT();" placeholder="填写整数" aria-describedby="basic-addon4">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon5">板子厚度</span>
                  <input type="text" class="form-control" id="banzihoudu" v-model="banhoudu" onchange="PMT();" placeholder="cm" aria-describedby="basic-addon5">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon5">拼版款数</span>
                  <input type="text" class="form-control" id="pingbankuanshu" v-model="pingbanks" onchange="PMT();" placeholder="填写整数" aria-describedby="basic-addon5">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">字符颜色</label>
                    <select class="form-control" id="zifuyanse" v-model="zifuys">
                      <option value="20" onchange="PMT();">白色</option>
                      <option value="50" onchange="PMT();">红色</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">阻焊颜色</label>
                    <select class="form-control" id="zuhanyanse" v-model="zuhanys">
                        <option value="20" onchange="PMT();">白色</option>
                        <option value="40" onchange="PMT();">蓝色</option>
                        <option value="30" onchange="PMT();">红色</option>
                        <option value="70" onchange="PMT();">紫色</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">需要发票？</label>
                    <select class="form-control" id="fapiao" v-model="selected">
                        <option value="15" onchange="PMT();">需要</option>
                        <option value="0" onchange="PMT();">不需要</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">发货时间</label>
                    <select class="form-control" id="fahuoshijian" v-model="fahuo">
                        <option value="0" onchange="PMT();">正常2-3天(样板)</option>
                        <option value="15" onchange="PMT();">样板48小时加急</option>
                        <option value="20" onchange="PMT();">正常3-4天(样板)</option>
                        <option value="25" onchange="PMT();">样板24小时加急</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">阻焊覆盖</label>
                    <select class="form-control" id="zuhanfugai" v-model="zuhanfg">
                        <option value="35" onchange="PMT();">过孔盖油</option>
                        <option value="45" onchange="PMT();">过孔开窗</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="disabledSelect">飞针测试</label>
                    <select class="form-control" id="feizhenceshi" v-model="feizhen">
                        <option v-for="option in options" v-bind:value="option.value" onchange="PMT();">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon18">总价格</span>
                  <input type="text" class="form-control" id="calSum" value="￥ " readonly="" aria-describedby="basic-addon18">
                </div>
            </div>
        </div>

        <div id="jieg" class="noprint">
            <button type="button" class="btn btn-primary"><a href="javascript:;" onclick="PMT();">计算</a></button>
            <button type="button" class="btn btn-warning"><a href="javascript:;" onclick="calClear();">清空</a></button>
            <button type="button" class="btn btn-success" id="btnPrint" onclick="javascript:window.print();">打印</button>
            <button type="button" class="btn btn-info" id="btnPrint" onclick=preview(1)>打印预览</button>
            <br>
            <div>
              <h2>订单明细<small> 如下</small></h2>
            </div>
        </div>
        <ul class="list-group">
          <li class="list-group-item">板子层数: {{ picked }} 层</li>
          <li class="list-group-item">板子宽度: {{ kuang }} cm</li>
          <li class="list-group-item">板子长度: {{ chang }} cm</li>
          <li class="list-group-item">板子数量: {{ shuliangss }} 块</li>
          <li class="list-group-item">板子厚度: {{ banhoudu }} cm</li>
          <li class="list-group-item">拼版款数: {{ pingbanks }} 个</li>
          <li class="list-group-item">字符颜色价格: {{ zifuys }} 元</li>
          <li class="list-group-item">阻焊颜色价格: {{ zuhanys }} 元</li>
          <li class="list-group-item">发票价格: {{ selected }} 元</li>
          <li class="list-group-item">发货方式价格: {{ fahuo }} 元</li>
          <li class="list-group-item">阻焊覆盖价格: {{ zuhanfg }} 元</li>
          <li class="list-group-item">飞针测试价格: {{ feizhen }} 元</li>
        </ul>
        <script>
            new Vue({
              el: '#zhib-daikjisuan',
              data: {
                picked : '2',
                kuang : '',
                chang : '',
                shuliangss : '',
                banhoudu : '',
                pingbanks : '1',
                zifuys : '',
                zuhanys : '',
                selected : '',
                fahuo : '',
                zuhanfg : '',
                feizhen : '',
                options: [
                  { text: '不测试', value: '0' },
                  { text: '全部测试(免费)', value: '15' }
                ]
              }
            })
        </script>
    </div>
    <div id="mianze">
        <p>
            算法最终解释权归鸢尾花序所有。
        </p>
    </div>
</div>

</div>

<!-- 自定义代码 结束 -->

        </main><!-- .site-main -->
    </div><!-- .content-area -->
<div class="noprint">
    <?php get_footer(); ?>
</div>