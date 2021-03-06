{* Smarty *}
{extends file='layouts/student.tpl'}
{block name=nav}
    {include 'components/student/nav_profile.tpl'}
{/block}
{block name='main'}

<div class="block">
    <div class="navbar navbar-inner block-header"><h4>个人信息</h4>
    </div>
    <div class="block-content collapse in">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>注意</h4>
            <p>
                如果遇到照片无法显示请务必修改照片。
                如果其他信息发现与本人信息不匹配，请联系教务处相关老师寻求解决。
            </p>
        </div>

        <div class="span12">
             <form class="form-horizontal">
              <fieldset>
                 <div class="control-group"></div>

                 <div class="control-group">
                  <label class="control-label">照片</label>
                    <div class="span3" style="width:150px;height:180px;">
                        <a href="#" class="thumbnail">
                            <img  style="width: 150px; height: 180px;" src="/index.php/image/{$info['name']}">
                        </a>
                    </div>
                </div>


                <div class="control-group">
                  <label class="control-label">学号</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['student_number']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">姓名</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['name']}</span>
                  </div>
                </div>
                 <div class="control-group">
                  <label class="control-label">学院</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['college']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">专业</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['major']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">年级</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['grade']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">班级</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['class']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">性别</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{if $data['sex'] eq 0}男{elseif $data['sex'] eq 1}女{else}未知{/if}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">民族</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['nation']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">身份证号码</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['id_card_number']}</span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">电话号码</label>
                  <div class="controls">
                    <span class="input-xlarge uneditable-input">{$data['telephone_number']}</span>
                  </div>
                </div>



              </fieldset>
            </form>

        </div>
    </div>
</div>

{/block}
