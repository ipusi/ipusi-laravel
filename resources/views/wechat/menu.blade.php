<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link href="{{asset('css/menu.css')}}" rel="stylesheet">
</head>

<body>
    <div class="content" style="width:90%;max-width:1000px;margin:0 auto;">
    <div id="app-menu-{{$id}}">
            <!-- 预览窗 -->
            <div class="weixin-preview">
                <div class="weixin-hd">
                    <div class="weixin-title">@{{weixinTitle}}</div>
                </div>
                <div class="weixin-bd">
                    <ul class="weixin-menu" id="weixin-menu">
                        <li v-for="(btn,i) in menu.button" class="menu-item" :class="{current:selectedMenuIndex===i&&selectedMenuLevel()==1}" @click="selectedMenu(i,$event)">
                            <div class="menu-item-title">
                                <i class="icon_menu_dot"></i>
                                <span>@{{ btn.name }}</span>
                            </div>
                            <ul class="weixin-sub-menu" v-show="selectedMenuIndex===i">
                                <li v-for="(sub,i2) in btn.sub_button" class="menu-sub-item" :class="{current:selectedSubMenuIndex===i2&&selectedMenuLevel()==2}"
                                    @click.stop="selectedSubMenu(i2,$event)">
                                    <div class="menu-item-title">
                                        <span>@{{sub.name}}</span>
                                    </div>
                                </li>
                                <li v-if="btn.sub_button.length<5" class="menu-sub-item" @click.stop="addMenu(2)">
                                    <div class="menu-item-title">
                                        <i class="icon14_menu_add"></i>
                                    </div>
                                </li>
                                <i class="menu-arrow arrow_out"></i>
                                <i class="menu-arrow arrow_in"></i>
                            </ul>
                        </li>
                        <li class="menu-item" v-if="menu.button.length<3" @click="addMenu(1)"> <i class="icon14_menu_add"></i></li>
                    </ul>
                </div>
            </div>
            <!-- 主菜单 -->
            <div class="weixin-menu-detail" v-if="selectedMenuLevel()==1">
                <div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
                    <div class="menu-name">@{{menu.button[selectedMenuIndex].name}}</div>
                    <div class="menu-del" @click="delMenu">删除菜单</div>
                </div>
                <div class="menu-input-group">
                    <div class="menu-label">菜单名称</div>
                    <div class="menu-input">
                        <input type="text" name="name" placeholder="请输入菜单名称" class="menu-input-text" v-model="menu.button[selectedMenuIndex].name"
                            @input="checkMenuName(menu.button[selectedMenuIndex].name)">
                        <p class="menu-tips" style="color:#e15f63" v-show="menuNameBounds">字数超过上限</p>
                        <p class="menu-tips">字数不超过4个汉字或8个字母</p>
                    </div>
                </div>
                <template v-if="menu.button[selectedMenuIndex].sub_button.length==0">
                        <div class="menu-input-group">
                            <div class="menu-label">菜单内容</div>
                            <div class="menu-input">
                                <select v-model="menu.button[selectedMenuIndex].type" name="type" class="menu-input-text">
                                    <option value="view">跳转网页(view)</option>
                                    <option value="media_id">发送消息(media_id)</option>
                                    <!--<option value="view_limited">跳转公众号图文消息链接(view_limited)</option>-->
                                    <option value="miniprogram">打开指定小程序(miniprogram)</option>
                                    <option value="click">自定义点击事件(click)</option>
                                    <option value="scancode_push">扫码上传消息(scancode_push)</option>
                                    <option value="scancode_waitmsg">扫码提示下发(scancode_waitmsg)</option>
                                    <option value="pic_sysphoto">系统相机拍照(pic_sysphoto)</option>
                                    <option value="pic_photo_or_album">弹出拍照或者相册(pic_photo_or_album)</option>
                                    <option value="pic_weixin">弹出微信相册(pic_weixin)</option>
                                    <option value="location_select">弹出地理位置选择器(location_select)</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-content" v-if="selectedMenuType()==1">
                            <div class="menu-input-group">
                                <p class="menu-tips">订阅者点击该子菜单会跳到以下链接</p>
                                <div class="menu-label">页面地址</div>
                                <div class="menu-input">
                                    <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].url">
                                    <p class="menu-tips cursor" @click="selectNewsUrl">从公众号图文消息中选择</p>
                                </div>
                            </div>
                        </div>
                        <div class="menu-msg-content" v-else-if="selectedMenuType()==2">
                            <div class="menu-msg-head"><i class="icon_msg_sender"></i>图文消息</div>
                            <div class="menu-msg-panel">
                                <div class="menu-msg-select" v-if="menu.button[selectedMenuIndex].media_id==''||menu.button[selectedMenuIndex].media_id==undefined" @click="selectMaterialId">
                                    <i class="icon36_common add_gray"></i>
                                    <strong>从素材库中选择</strong>
                                </div>
                                <div class="menu-msg-select" v-else>
                                    <div class="menu-msg-title"><i class="icon_msg_sender"></i>@{{material.title}}</div>
                                    <a :href="material.url" target="_blank" class="btn btn-sm btn-info">查看</a>
                                    <div class="btn btn-sm btn-danger" @click="delMaterialId">删除</div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" v-else-if="selectedMenuType()==3">
                            <div class="menu-input-group">
                                <p class="menu-tips">用于消息接口推送，不超过128字节</p>
                                <div class="menu-label">菜单KEY值</div>
                                <div class="menu-input">
                                    <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].key">
                                </div>
                            </div>
                        </div>
                        <div class="menu-content" v-else-if="selectedMenuType()==4">
                            <div class="menu-input-group">
                                <p class="menu-tips">订阅者点击该子菜单会跳到以下小程序</p>
                                <div class="menu-label">小程序APPID</div>
                                <div class="menu-input">
                                    <input type="text" placeholder="小程序的appid（仅认证公众号可配置）" class="menu-input-text" v-model="menu.button[selectedMenuIndex].appid">
                                </div>
                            </div>
                            <div class="menu-input-group">
                                <div class="menu-label">小程序路径</div>
                                <div class="menu-input">
                                    <input type="text" placeholder="小程序的页面路径 pages/Index/index" class="menu-input-text" v-model="menu.button[selectedMenuIndex].pagepath">
                                </div>
                            </div>
                            <div class="menu-input-group">
                                <div class="menu-label">备用网页</div>
                                <div class="menu-input">
                                    <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].url">
                                    <p class="menu-tips">旧版微信客户端无法支持小程序，用户点击菜单时将会打开备用网页。</p>
                                </div>
                            </div>
                        </div>
                    </template>
            </div>
            <!-- 子菜单 -->
            <div class="weixin-menu-detail" v-if="selectedMenuLevel()==2">
                <div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
                    <div class="menu-name">@{{menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name}}</div>
                    <div class="menu-del" @click="delMenu">删除子菜单</div>
                </div>
                <div class="menu-input-group">
                    <div class="menu-label">子菜单名称</div>
                    <div class="menu-input">
                        <input type="text" placeholder="请输入子菜单名称" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name"
                            @input="checkMenuName(menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name)">
                        <p class="menu-tips" style="color:#e15f63" v-show="menuNameBounds">字数超过上限</p>
                        <p class="menu-tips">字数不超过8个汉字或16个字母</p>
                    </div>
                </div>
                <div class="menu-input-group">
                    <div class="menu-label">子菜单内容</div>
                    <div class="menu-input">
                        <select v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].type" name="type" class="menu-input-text">
                                <option value="view">跳转网页(view)</option>
                                <option value="media_id">发送消息(media_id)</option>
                                <!--<option value="view_limited">跳转公众号图文消息链接(view_limited)</option>-->
                                <option value="miniprogram">打开指定小程序(miniprogram)</option>
                                <option value="click">自定义点击事件(click)</option>
                                <option value="scancode_push">扫码上传消息(scancode_push)</option>
                                <option value="scancode_waitmsg">扫码提示下发(scancode_waitmsg)</option>
                                <option value="pic_sysphoto">系统相机拍照(pic_sysphoto)</option>
                                <option value="pic_photo_or_album">弹出拍照或者相册(pic_photo_or_album)</option>
                                <option value="pic_weixin">弹出微信相册(pic_weixin)</option>
                                <option value="location_select">弹出地理位置选择器(location_select)</option>
                            </select>
                    </div>
                </div>
                <div class="menu-content" v-if="selectedMenuType()==1">
                    <div class="menu-input-group">
                        <p class="menu-tips">订阅者点击该子菜单会跳到以下链接</p>
                        <div class="menu-label">页面地址</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].url">
                            <p class="menu-tips cursor" @click="selectNewsUrl">从公众号图文消息中选择</p>
                        </div>
                    </div>
                </div>
                <div class="menu-msg-content" v-else-if="selectedMenuType()==2">
                    <div class="menu-msg-head"><i class="icon_msg_sender"></i>图文消息</div>
                    <div class="menu-msg-panel">
                        <div class="menu-msg-select" v-if="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].media_id==''||menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].media_id==undefined"
                            @click="selectMaterialId">
                            <i class="icon36_common add_gray"></i>
                            <strong>从素材库中选择</strong>
                        </div>
                        <div class="menu-msg-select" v-else>
                            <i class="icon_msg_sender"></i>@{{material.title}}
                            <a :href="material.url" target="_blank" class="btn btn-sm btn-info">查看</a>
                            <div class="btn btn-sm btn-danger" @click="delMaterialId">删除</div>
                        </div>
                    </div>
                </div>
                <div class="menu-content" v-else-if="selectedMenuType()==3">
                    <div class="menu-input-group">
                        <p class="menu-tips">用于消息接口推送，不超过128字节</p>
                        <div class="menu-label">菜单KEY值</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].key">
                        </div>
                    </div>
                </div>
                <div class="menu-content" v-else-if="selectedMenuType()==4">
                    <div class="menu-input-group">
                        <p class="menu-tips">订阅者点击该子菜单会跳到以下小程序</p>
                        <div class="menu-label">小程序APPID</div>
                        <div class="menu-input">
                            <input type="text" placeholder="小程序的appid（仅认证公众号可配置）" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].appid">
                        </div>
                    </div>
                    <div class="menu-input-group">
                        <div class="menu-label">小程序路径</div>
                        <div class="menu-input">
                            <input type="text" placeholder="小程序的页面路径 pages/Index/index" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].pagepath">
                        </div>
                    </div>
                    <div class="menu-input-group">
                        <div class="menu-label">备用网页</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].url">
                            <p class="menu-tips">旧版微信客户端无法支持小程序，用户点击菜单时将会打开备用网页。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="weixin-btn-group">
            <div id="btn-create" class="btn btn-success">发布</div>
            <div id="btn-clear" class="btn btn-danger">清空</div>
        </div>
    </div>

    <!-- 弹出层 -->
    <div id="news-list" style="display: none;">
        <table id="news-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>图文标题</th>
                    <th width="130">日期</th>
                    <th width="130">操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div id="material-list" style="display: none;">
        <table id="material-table" class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>素材名称</th>
                    <th width="130">操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="{{asset('js/tmpl.min.js')}}"></script>
    <script src="{{asset('js/layer.js')}}"></script>
    <script id="material-tpl" type="text/x-tmpl">
        {% for (var i=0; i<o.length; i++) { %}
            <tr>
                <td>
                    <ul>
                        {% for (var j=0; j<o[i].content.news_item.length; j++) { %}
                            <li>
                                <a href="{%=o[i].content.news_item[j].url %}" target="_blank">
                                    {%=j+1 %}.
                                        {%=o[i].content.news_item[j].title %}
                                </a>
                            </li>
                        {% } %}
                    </ul>
                </td>
                <td>
                    <button onclick="app.setMaterialId('{%=o[i].media_id%}','{%=o[i].content.news_item[0].title%}','{%=o[i].content.news_item[0].url%}')"
                        class="btn btn-primary">选择</button>
                </td>
            </tr>
        {% } %}
    </script>

    <script id="news-tpl" type="text/x-tmpl">
        {% for (var i=0; i<o.length; i++) { %}
            {% for (var j=0; j<o[i].content.news_item.length; j++) { %}
                <tr>
                    <td>{%=o[i].content.news_item[j].title %}</td>
                    <td>{% var d=new Date(o[i].content.update_time*1000); print(d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate()); %}</td>
                    <td>
                        <a href="{%=o[i].content.news_item[j].url %}" target="_blank" class="btn btn-info">查看</a>
                        <button onclick="app.setNewsUrl('{%=o[i].content.news_item[j].url %}')" class="btn btn-primary btn-material-id">选择</button>
                    </td>
                </tr>
            {% } %}
        {% } %}
    </script>

    <script>
        var getMenuAPI= "/api/wechat/{{$id}}/menu";
        var publishMenuAPI='/api/wechat/{{$id}}/menu/publish';
        var clearMenuAPI="/api/wechat/{{$id}}/menu/clear";
        var getMaterialAPI='/api/wechat/{{$id}}/material';
        var getNewsAPI='';
    
        var that=this
    
        //列表偏移和总数
        var newsListOffset=0;
        var materialListOffset=0;
        var newsListTotal=0;
        var materialListTotal=0;
    
        //Vue
        var app = new Vue({
            el: '#app-menu-{{$id}}',
            data: {
                weixinTitle: 'Vue.js公众号菜单',
                menu: {'button': []},//当前菜单
                selectedMenuIndex:'',//当前选中菜单索引
                selectedSubMenuIndex:'',//当前选中子菜单索引
                menuNameBounds:false,//菜单长度是否过长
                material:{
                    title:'',
                    url:'',
                    thumb_url:''
                }
            },
            mounted:function(){
                this.getMenu()
            },
            methods: {
                getMenu:function(){
                    var _this=this
                    $.ajax({
                        type: 'GET',
                        timeout: 20000,
                        url: getMenuAPI,
                        async: false,
                        dataType: 'json',
                        success: function (res) {
                            _this.menu=res.list.menu;
                            _this.weixinTitle = res.name;
                        }
                    })
                },
                //选中主菜单
                selectedMenu:function(i,event){
                    this.selectedSubMenuIndex=''
                    this.selectedMenuIndex=i
                    var selectedMenu=this.menu.button[this.selectedMenuIndex]
                    //清空选中media_id 防止再次请求
                    if(selectedMenu.media_id!=undefined&&selectedMenu.media_id!=''&&this.selectedMenuType()==2){
                        this.getMaterial(selectedMenu.media_id)
                    }
                    //检查名称长度
                    this.checkMenuName(selectedMenu.name)
                },
                //选中子菜单
                selectedSubMenu:function(i,event){
                    this.selectedSubMenuIndex=i
                    var selectedSubMenu=this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex]
                    if(selectedSubMenu.media_id!=undefined&&selectedSubMenu!=''&&this.selectedMenuType()==2){
                        this.getMaterial(selectedSubMenu.media_id)
                    }
                    this.checkMenuName(selectedSubMenu.name)
                },
                //选中菜单级别
                selectedMenuLevel: function () {
                    if (this.selectedMenuIndex !== '' && this.selectedSubMenuIndex === '') {
                        //主菜单
                        return 1;
                    }else if (this.selectedMenuIndex !== '' && this.selectedSubMenuIndex !== '') {
                        //子菜单
                        return 2;
                    }else {
                        //未选中任何菜单
                        return 0;
                    }
                },
                //获取菜单类型 1. view网页类型，2. media_id类型和view_limited类型 3. click点击类型，4.miniprogram表示小程序类型
                selectedMenuType: function () {
                    if (this.selectedMenuLevel() == 1&&this.menu.button[this.selectedMenuIndex].sub_button.length==0) {
                        //主菜单
                        switch (this.menu.button[this.selectedMenuIndex].type) {
                            case 'view':return 1;
                            case 'media_id':return 2;
                            case 'view_limited':return 2;
                            case 'click':return 3;
                            case 'scancode_push':return 3;
                            case 'scancode_waitmsg':return 3;
                            case 'pic_sysphoto':return 3;
                            case 'pic_photo_or_album':return 3;
                            case 'pic_weixin':return 3;
                            case 'location_select':return 3;
                            case 'miniprogram':return 4;
                        }
                    } else if (this.selectedMenuLevel() == 2) {
                        //子菜单
                        switch (this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex].type) {
                            case 'view':return 1;
                            case 'media_id':return 2;
                            case 'view_limited':return 2;
                            case 'click':return 3;
                            case 'scancode_push':return 3;
                            case 'scancode_waitmsg':return 3;
                            case 'pic_sysphoto':return 3;
                            case 'pic_photo_or_album':return 3;
                            case 'pic_weixin':return 3;
                            case 'location_select':return 3;
                            case 'miniprogram':return 4;
                        }
                    } else {
                        return 1;
                    }
                },
                //添加菜单
                addMenu:function(level){
                    if(level==1&&this.menu.button.length<3){
                        this.menu.button.push({
                            "type": "view",
                            "name": "菜单名称",
                            "sub_button": [],
                            "url":""
                        })
                        this.selectedMenuIndex=this.menu.button.length-1
                        this.selectedSubMenuIndex=''
                    }
                    if(level==2&&this.menu.button[this.selectedMenuIndex].sub_button.length<5){
                        this.menu.button[this.selectedMenuIndex].sub_button.push({
                            "type": "view",
                            "name": "子菜单名称",
                            "url":""
                        })
                        this.selectedSubMenuIndex=this.menu.button[this.selectedMenuIndex].sub_button.length-1
                    }
                },
                //删除菜单
                delMenu:function(){
                    if(this.selectedMenuLevel()==1&&confirm('删除后菜单下设置的内容将被删除')){
                        if(this.selectedMenuIndex===0){
                            this.menu.button.splice(this.selectedMenuIndex, 1);
                            this.selectedMenuIndex = 0;
                        }else{
                            this.menu.button.splice(this.selectedMenuIndex, 1);
                            this.selectedMenuIndex -=1;
                        }
                        if(this.menu.button.length==0){
                            this.selectedMenuIndex = ''
                        }
                    }else if(this.selectedMenuLevel()==2){
                        if(this.selectedSubMenuIndex===0){
                            this.menu.button[this.selectedMenuIndex].sub_button.splice(this.selectedSubMenuIndex, 1);
                            this.selectedSubMenuIndex = 0;
                        }else{
                            this.menu.button[this.selectedMenuIndex].sub_button.splice(this.selectedSubMenuIndex, 1);
                            this.selectedSubMenuIndex -= 1;
                        }
                        if(this.menu.button[this.selectedMenuIndex].sub_button.length==0){
                            this.selectedSubMenuIndex = ''
                        }
                    }
                },
                //检查菜单名称长度
                checkMenuName:function(val){
                    if(this.selectedMenuLevel()==1&&this.getMenuNameLen(val)<=8){
                        this.menuNameBounds=false
                    }else if(this.selectedMenuLevel()==2&&this.getMenuNameLen(val)<=16){
                        this.menuNameBounds=false
                    }else{
                        this.menuNameBounds=true
                    }
                },
                //获取菜单名称长度
                getMenuNameLen: function (val) {
                    var len = 0;
                    for (var i = 0; i < val.length; i++) {
                        var a = val.charAt(i);
                        a.match(/[^\x00-\xff]/ig) != null?len += 2:len += 1;
                    }
                    return len;
                },
                //选择公众号素材库素材
                selectMaterialId:function(){
                    layer.open({
                        type: 1,
                        title:'选择素材',
                        area: ['900px', '600px'], //宽高
                        content: $('#material-list'),
                        scrollbar: false,
                        success:function(){
                            if($('#material-list').find('tbody').children().length==0){
                                getMaterialList(0)
                            }
                        }
                    });
                },
                //选择公众号图文链接
                selectNewsUrl:function(){
                    layer.open({
                        type: 1,
                        title:'选择图文',
                        area: ['850px', '600px'], //宽高
                        content: $('#news-list'),
                        scrollbar: false,
                        success:function(){
                            if($('#news-list').find('tbody').children().length==0){
                                getNewsList()
                            }
                        }
                    })
                },
                //设置选择的素材id
                setMaterialId:function(id,title,url){
                    if(this.selectedMenuLevel()==1){
                        Vue.set(this.menu.button[this.selectedMenuIndex],'media_id',id) 
                    }else if(this.selectedMenuLevel()==2){
                        Vue.set(this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex],'media_id',id)
                    }
                    this.material.title=title
                    this.material.url=url
                    layer.close(layer.index);
                },
                //删除选择的素材id
                delMaterialId:function(){
                    if(this.selectedMenuLevel()==1){
                        this.menu.button[this.selectedMenuIndex].media_id=''
                    }else if(this.selectedMenuLevel()==2){
                        this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex].media_id=''
                    }
                },
                //设置选择的图文链接
                setNewsUrl:function(url){
                    if(this.selectedMenuLevel()==1){
                        Vue.set(this.menu.button[this.selectedMenuIndex],'url',url)
                    }else if(this.selectedMenuLevel()==2){
                        Vue.set(this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex],'url',url)
                    }
                    layer.close(layer.index);
                },
                //获取素材信息
                getMaterial:function(id){
                    var _this=this
                    $.ajax({
                        type: 'POST',
                        timeout: 20000,
                        url: getMaterialAPI,
                        data:{
                        'media_id':id
                        },
                        async: false,
                        dataType: 'json',
                        success: function (res) {
                            _this.material.title=res.news_item[0].title
                            _this.material.url=res.news_item[0].url
                            
                        }
                    })
                }
            }
        })
    
        //发布菜单
        $('#btn-create').click(function(){
            var layerId = layer.load(2);
            $.ajax({
                type: 'POST',
                timeout: 20000,
                url: publishMenuAPI,
                data:{
                    "menu":JSON.stringify(app.menu)
                },
                async: true,
                dataType: 'json',
                success: function (res) {
                    layer.close(layerId);
                    if (res.errcode == 0) {
                        layer.msg('发布自定义菜单成功')
                    }else{
                        layer.msg('发布自定义菜单失败：'+res.errmsg)
                    }
                },
                error:function(){
                    layer.close(layerId);
                    layer.msg('网络错误')
                }
            })
        })
        //清空菜单
        $('#btn-clear').click(function(){
            if(!confirm('确定后将清空后公众号自定义菜单')){
                return false;
            }
            var layerId = layer.load(2);
            $.ajax({
                type: 'POST',
                timeout: 20000,
                url: clearMenuAPI,
                data:{
                    "menu":JSON.stringify(app.menu)
                },
                async: true,
                dataType: 'json',
                success: function (res) {
                    layer.close(layerId);
                    if (res.errcode == 0) {
                        layer.msg('清空成功')
                    }else{
                        layer.msg('清空失败：'+res.errmsg)
                    }
                },
                error:function(){
                    layer.close(layerId);
                    layer.msg('网络错误')
                }
            })
        })
        //获取素材列表
        function getMaterialList(offset){
            $.ajax({
                type: 'POST',
                timeout: 20000,
                url: getMaterialAPI,
                data:{
                    'type':'news',
                    'offset':offset,
                    'count':20
                },
                async: false,
                dataType: 'json',
                success: function (res) {
                    var html=tmpl('material-tpl',res.item)
                    $('#material-table').find('tbody').append(html)
                    that.materialListOffset+=res.item_count;
                    that.materialListTotal+=res.total_count;
                    
                }
            })
        }
        //获取图文列表
        function getNewsList(offset){
            $.ajax({
                type: 'POST',
                timeout: 20000,
                url:getMaterialAPI,
                data:{
                    'offset':offset,
                    'count':1
                },
                async: false,
                dataType: 'json',
                success: function (res) {
                    var html=tmpl('news-tpl',res.item);
                    $('#news-list').find('tbody').append(html);
                    that.newsListOffset+=res.item_count;
                    that.newsListTotal+=res.total_count;
                }
            })
        }
    
        //滚动加载
        $('#material-list').on('scroll',function(){
            var offset=that.materialListOffset+20
            var sum = this.scrollHeight-50;
            if (sum <= $(this).scrollTop() + $(this).height()&&offset<that.materialListTotal) {
                getMaterialList(offset)
            }
        })
    
        $('#news-list').on('scroll',function(){
            var offset=that.newsListOffset+20
            var sum = this.scrollHeight-50;
            if (sum <= $(this).scrollTop() + $(this).height()&&offset<that.newsListTotal) {
                getNewsList(offset)
            }
        })
    </script>
</body>

</html>