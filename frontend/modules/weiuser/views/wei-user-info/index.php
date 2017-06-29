<?php
$this->title = "个人中心";
$this->registerCss("
    .weui_media_box {padding: 8px 15px;}
    .weui_media_appmsg_thumb{border-radius:3px;}
    .weui_panel{background-color: transparent;}
    .weui_panel_bd{margin-top: 10px;background-color: #fff;}
    .weui_media_small_appmsg p{margin-bottom:0;font-size:14px;}
    .weui_tabbar:before{border-color:#d9d9d9;}
    a:hover, a:focus{text-decoration: none;}
    .weui_cell_bd.weui_cell_primary{margin-left:10px;}
");
?>
<div class="weui_panel weui_panel_access" style="">
    <div class="weui_panel_bd">
        <a href="javascript:void(0);" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
                <img class="weui_media_appmsg_thumb" src="<?=$model->headimgurl?>" />
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title"><?=$model->nickname?></h4>
                <p class="weui_media_desc">十三编号：<?=$model->thirteen_platform_number?></p>
            </div>
        </a>
    </div>

    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_small_appmsg">
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="javascript:;">
                    <div class="weui_cell_hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>心动币</p>
                    </div>
                    <span class="weui_cell_ft"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_small_appmsg">
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="javascript:;">
                    <div class="weui_cell_hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>会员等级</p>
                    </div>
                    <span class="weui_cell_ft"></span>
                </a>
                <a class="weui_cell" href="javascript:;">
                    <div class="weui_cell_hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>档案资料</p>
                    </div>
                    <span class="weui_cell_ft"></span>
                </a>
                <a class="weui_cell" href="javascript:;">
                    <div class="weui_cell_hd">
                        <img alt="" style="width:20px;margin-right:5px;display:block" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAFQ0lEQVRoge1Ya2yTVRh+3q9du0sHW92wA7pNRiagzAAmihfCZrYBjnAxURQ0YRCCECMGiJgYmb8MXkJEcYpCjBJjglw0QjcwUcMPyYIiqImEjdENEAZUuw06u37n8cec9PK1Wy/TxPRJ3h/fOc95z/Oc9+s55yuQRhpppJFGEpB4B7zXvarArJvnCfggiKkQKQU5eqCXVwF0iUg7KS0CzbXc/vZPKdYcgmEb2OlZ9QAg60GZD8AUxxw/Q7g9N9+z61HZ449fYmwMaaDx0uoxZjPfFXBRUjMR7Rq4vL7w/W+TyhOGmAY+uLLqYYK7AIxJ0XwK4NYLBeM3NUhDIBUJoxrY0bWinsAOxPe6DAsEv7QX9jySildKM2psvLS8TlHtIJWJVEh1gKzzdNl2JiseMKhA49WnxjGAUwDsqZggFgiuXOv4OCkjEQa2X1q2G8RSI/LpVg8ONLUCABbMmYhJE409nm714PPmVihFLJ5XjvKy/GjzX7MG/ixf6dzjSUx+2Cu0reOxMqWrx5VSMIovDrehp9ePnl4/9h86Y8hRSmG/6wy6e/zovd6P/a7oPKXULT4xP52o+AgD1OQJRV1T1GEUAEMGR+cFJ2VUnqIOBWVY7YQMKBWoUkpHtJj7UAlybRnItWVgfk1JVF5dTSlybRbkZGegrrY0Ku/vmPxWx5KxiRoI+Q284V58Ganb84cNDVL9XMnerxIZG2LgtXML+kGYUyMrEqPNt6Is8x6Ms06G3eyEzWSHSTJAqH6B1gmRXwgcha7vzczMPDucnCEGtrTV9QCwpVq4w1KOmaOWoDizInzKaCCAI0pkc7bFciwWMWS1FfUOAFMSVhqeXCyYlVePClstAAnbAmJCANQIWX2jr68xy2pdLyJ9hnMEPyilWgCmxIBVy8aiggYUWSeBBMJ3sGFCAKzx+f3TPORcu4g3nBC6jQr3KSokGwINCws2w5FxO6iYfOhqptXXd5CkJdxASAUC5/0ucUgrgImJLNcg7stbOiCeN1f9bHs7mg43gyTm1tZiwm0TIsadc5/DoaYmgMScSM79vTduvATgxeDGkAo0VH4TUHrghZgHzxBhM9kx3bYwoiqu5iZ4vV50d3fjoMtlWDlXczO8Xi+83d1wNTdH9JPc4PH5iqMaAICX7zz6mVLq0xjHf8y4I7sGGswgGRGD0HXdsD+YE6XfagoE6mMaAABTn28Fqb5L5KpcbJkGpRgRVbMrkZWVhezsbNRUVxtzKgc4OTk5qJpdacihYm2w1qib8vPHZ4zWLOZ9AlRF4xjhmfH7YNVy4hkSL/6w5+X9c701rAAAbLn7e6/1WlYtqPbGU4EMZBmuXApjVLDOqAaAgR+1Th6JZwvtDfye9DY8RFwJ1jjkvUdRnyU33zQCOEZBvhCTjPhd/jaUWKcPlTZxCH4MfoxtgBCc4EMcOEVbhNqzr8744RgAbDhZMQa6qUKjchJSKEIBNK9f992lyNUjpZ8KB4KfY96sNp2amh/o11pE8ErOtJMfNgjUUBN0dXXZ+smzAAqT1GqY3kROcDgc1wcb4v5rcTg4f/HykxB+lOq8FCx1OhyfBLeNiAEA6Ljw2zsQJPW9GwKisXhc0Zrw5hEzQNLUefHimwTWpiDdtuKxY9eJSMSVdsQMDMLd2bmMkK0AChLLwNdLnc6N0XpjngOpQInTubu/z1emqDYqslORiCcIXImVf8QrEAySWpvbfa+IzCK0KQIWAcgC6BXIVYInABwXoIiQBgx8HR4pKymu+Td1pgRfk+Y2t3tdq9v963+tJY000kjjf4y/ABnxFbzdzXEEAAAAAElFTkSuQmCC">
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>微信认证</p>
                    </div>
                    <span class="weui_cell_ft"></span>
                </a>
            </div>
        </div>
    </div>

    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_small_appmsg">
            <div class="weui_cells weui_cells_access">
                <a class="weui_cell" href="javascript:;">
                    <div class="weui_cell_hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p>设置</p>
                    </div>
                    <span class="weui_cell_ft"></span>
                </a>
            </div>
        </div>
    </div>

</div>