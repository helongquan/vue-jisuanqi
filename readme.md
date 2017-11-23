这个版本支持了计价器的乘法和加法混合使用，以及引入了select的方式，根据下拉式选择不同的选项，计算不同的价格

必要的文件引入：jquery.js和jquery.lightbox_me.js

我这个是以wordpress的默认主题twentyfifteen作为测试的，在主题的目录下新建一个页面模板文件。这里已经做好了，把jisuanqi.php传上去即可，然后在页面那里，调用这个模板即可，如果是其他主题，可以把page.php文件下载下来，重命名成自己想要的即可，然后给模板命名，把我这个里面有关计算器的东西加进去即可。

这里为了能够动态的显示计价器所选择的内容，引入了vue.js这个。

在wordpress网站里面，我在header.php的head标签里面引入了：

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.lightbox_me.js"></script>  //控制弹窗的js文件
	<script src="https://cdn.bootcss.com/vue/2.5.3/vue.min.js"></script>  //双向绑定，动态显示输入框的值

控制样式的代码为：

	<style type="text/css">
	    #zhib-cal{
	    background:#03A9F4;
	    width:440px;
	    /*height:510px;*/
	    box-shadow: 1px 1px 14px 4px #586298;
	    }
	
	    #calSum,#calAmount,#calYear,#calPrecent{
	        height: 32px;
	        width: 220px;
	        font-size: 14px;
	        margin:10px 0px;
	        border: 1px solid #ddd;
	    }
	    #calSum{
	        background: #999999;
	        color:#FFF;
	    }
	    #zhib-daikjisuan{
	        padding: 0px;
	    }
	
	    #zhib-daikjisuan-title{
	        background: #666;
	        padding: 5px;
	        color: #fff;
	    }
	
	    #zhib-daikjisuan-title p{
	        font-size: 16px;
	        text-align: center;
	        font-weight: bold;
	        color: #baa26c;
	    }
	
	    #calAmount,#calYear,#calPrecent{
	        background: #f5f5f5;
	        border-radius: 3px;
	        color:#333333;
	
	    }
	    #jisuan-jieguo{
	        margin: 0px auto;
	        padding: 10px;
	    }
	    #jisuan-jieguo p{
	        text-align: center;
	    }
	
	    #jisuan-jieguo a{
	        background: #333333;
	        border-radius: 2px;
	        padding: 10px 20px;
	        text-decoration: none;
	        color: #fff;
	    }
	    #jisuan-jieguo a:hover{
	        color: #ffffff;
	        background:#000000;
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
	
	    #zhib-zhognjain{
	        padding: 20px 10px;
	    }
	    #zhib-zhognjain table{
	     border:0px;
	    }
	    #zhib-zhognjain table td{
	     border-width: 0px 0px 0px 0px;
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
	
	    a:hover{
	    color:#999 !important;
	    }
	
	</style>

控制计算的js代码为：

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
	            // document.getElementById('result').innerHTML="<div><p>板子层数："cengs"</p><p>板子宽度："kuangd"</p><p>板子长度："changd"</p><p>板子数量："shul"</p></div>"
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

表单内容显示的区域代码：

<div id="jisuanji-anj">
        <a class="buttons" href="javascript:;" onclick="showLightBox(&#39;calculator&#39;);">
            <div style="padding:15px 0;">PCB在线计价</div>
        </a>
    </div>
    <div id="calculator" class="lightBox" style="left: 50%; margin-left: -170.5px; z-index: 1002; position: fixed; top: 40%; margin-top: -60px; display: none;">
        <div id="zhib-cal">

            <div id="zhib-daikjisuan">

                <div id="zhib-daikjisuan-title">
                    <p>PCB在线计价</p>
                </div>
                <div id="zhib-zhognjain">
                    <table>
                    	<tr>
                            <td>
                                板子层数
                            </td>
                            <td>
                                <input type="text" id="cengshu" v-model="picked" onchange="PMT();" placeholder="cm">
                            </td>
                            <td>
                                板子宽度
                            </td>
                            <td>
                                <input type="text" id="kuangdu" v-model="kuang" onchange="PMT();" placeholder="cm">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                板子长度
                            </td>
                            <td>
                                <input type="text" id="changdu" v-model="chang" onchange="PMT();" placeholder="cm">
                            </td>
                            <td>
                                板子数量
                            </td>
                            <td>
                                <input type="text" id="shuliang" v-model="shuliangss" onchange="PMT();" placeholder="填写整数">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                板子厚度
                            </td>
                            <td>
                                <input type="text" id="banzihoudu" v-model="banhoudu" onchange="PMT();" placeholder="cm">
                            </td>
                            <td>
                                拼版款数
                            </td>
                            <td>
                                <input type="text" id="pingbankuanshu" v-model="pingbanks" onchange="PMT();" placeholder="填写整数">
                            </td>
                        </tr>
						<tr>
                            <td>
                                字符颜色
                            </td>
                            <td>
                                <select id="zifuyanse" v-model="zifuys">
                                    <option value="20" onchange="PMT();">白色</option>
                                    <option value="50" onchange="PMT();">红色</option>
                                </select>
                            </td>
                            <td>
                                阻焊颜色
                            </td>
                            <td>
                            	<select id="zuhanyanse" v-model="zuhanys">
                            		<option value="20" onchange="PMT();">白色</option>
                            		<option value="40" onchange="PMT();">蓝色</option>
                            		<option value="30" onchange="PMT();">红色</option>
                            		<option value="70" onchange="PMT();">紫色</option>
                            	</select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                需要发票？
                            </td>
                            <td>
                                <select id="fapiao" v-model="selected">
                                    <option value="15" onchange="PMT();">需要</option>
                                    <option value="0" onchange="PMT();">不需要</option>
                                </select>
                            </td>
                            <td>
                                发货时间
                            </td>
                            <td>
                                <select id="fahuoshijian" v-model="fahuo">
                                    <option value="0" onchange="PMT();">正常2-3天(样板)</option>
                                    <option value="15" onchange="PMT();">样板48小时加急</option>
                                    <option value="20" onchange="PMT();">正常3-4天(样板)</option>
                                    <option value="25" onchange="PMT();">样板24小时加急</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                阻焊覆盖
                            </td>
                            <td>
                                <select id="zuhanfugai" v-model="zuhanfg">
                                    <option value="35" onchange="PMT();">过孔盖油</option>
                                    <option value="45" onchange="PMT();">过孔开窗</option>
                                </select>
                            </td>
                            <td>
                                飞针测试
                            </td>
                            <td>
                                <select id="feizhenceshi" v-model="feizhen">
                                    <!-- <option value="0" onchange="PMT();">全部测试(免费)</option> -->
                                    <option v-for="option in options" v-bind:value="option.value" onchange="PMT();">
                                    {{ option.text }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                总价格
                            </td>
                            <td>
                                <input type="text" id="calSum" value="￥ " readonly="">
                            </td>
                        </tr>
                    </table>
                    <div id="jieg">
                        <div>
                            订单明细：
                        </div>
                    </div>

                  <span>板子层数: {{ picked }}</span>&nbsp;&nbsp;<span>板子宽度: {{ kuang }}</span>&nbsp;&nbsp;<span>板子宽度: {{ chang }}</span>&nbsp;&nbsp;<span>板子数量: {{ shuliangss }}</span><br>
                  <span>板子厚度: {{ banhoudu }}</span>&nbsp;&nbsp;<span>拼版款数: {{ pingbanks }}</span>&nbsp;&nbsp;<span>字符颜色: {{ zifuys }}</span>&nbsp;&nbsp;<span>阻焊颜色: {{ zuhanys }}</span><br>
                  <span>需要发票？: {{ selected }}</span>&nbsp;&nbsp;<span>发货时间: {{ fahuo }}</span>&nbsp;&nbsp;<span>阻焊覆盖: {{ zuhanfg }}</span><br>
                  <span>飞针测试: {{ feizhen }}</span>
                    <script>
                        new Vue({
                          el: '#zhib-zhognjain',
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
                <div id="jisuan-jieguo">
                    <p>
                    <span><a href="javascript:;" onclick="PMT();">计算</a></span>
                    <span><a href="javascript:;" onclick="calClear();">清空</a></span>
                    <span><a href="#" class="button" onClick="closeTuceng()">关闭</a></span>
                    </p>
                </div>
                <div id="mianze">
                    <p>
                        版权归诺科帝科技有限公司所有。
                    </p>
                </div>
            </div>
        </div>
    </div>

随后，做了另外一个版本，不用以弹窗的形式展示出来，而是直接显示的方式，代码在文件page-jisuanqi-2.php里面，这个额外引用了bootstrap.min.css这个样式。采用这种方式的时候，记得把这个样式文件引入即可。