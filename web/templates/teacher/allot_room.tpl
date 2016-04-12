{* Smarty *}
{extends file='../layouts/teacher.tpl'}
{block name=nav}
    {include 'components/teacher/nav_room.tpl'}
{/block}
{block name='main'}
<div class="block">
    <div class="navbar navbar-inner block-header">
    </div>
    <div class="block-content collapse in">
     <form class="form-horizontal">
              <fieldset>
        <legend>分配考场</legend>

               <button class="btn btn-primary"> &nbsp&nbsp&nbsp分配考场&nbsp&nbsp&nbsp </button>
               <button class="btn btn-primary"> &nbsp&nbsp&nbsp重新分配&nbsp&nbsp&nbsp </button>
               <button class="btn btn-primary"> &nbsp&nbsp&nbsp导出所有准考证&nbsp&nbsp&nbsp </button>

        <div class="block-content collapse in">
         <div class="span6" align="left" style="width="100%""></div>
       <div class="span6" align="right" style="width="100%""><div id="example2_filter" class="dataTables_filter"><label>Search: <input aria-controls="example2" type="text"></label></div></div>

        <div class="span12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th>学号</th>
                  <th>姓名</th>
                  <th>考号</th>
                  <th>考场</th>
                  <th>导出准考证</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td><button class="btn btn-primary btn-mini">导出</button></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td><button class="btn btn-primary btn-mini">导出</button></td>
                </tr>
                <tr>
                   <td>3</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td>Otto</td>
                  <td><button class="btn btn-primary btn-mini">导出</button></td>
                </tr>
              </tbody>
            </table>
        </div>

       </fieldset>
       </form>
    </div>
</div>
{/block}