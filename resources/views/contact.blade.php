<link rel="stylesheet" href="{{url('static/contact/css/element.min.css')}}">
<div>
<div id="myVue">
    <template>
        <el-tabs v-model="activeName" tab-click="handleClick">
        <el-tab-pane label="组织负责人" name="first">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>职位</th>
                    <th>学院</th>
                    <th>年级</th>
                    <th>电话</th>
                    <th>QQ</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($array[1] as $item)
                    @if($i<4)
                    <tr class="success">
                        <th scope="row"><?php echo $i++;?></th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->department}}</td>
                        <td>{{$item->position}}</td>
                        <td>{{$item->college}}</td>
                        <td>{{$item->grade}}</td>
                        <td><b>{{$item->tel}}</b></td>
                        <td><b>{{$item->qq}}</b></td>
                    </tr>
                    @else
                    <tr>
                        <th scope="row"><?php echo $i++;?></th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->department}}</td>
                        <td>{{$item->position}}</td>
                        <td>{{$item->college}}</td>
                        <td>{{$item->grade}}</td>
                        <td><b>{{$item->tel}}</b></td>
                        <td><b>{{$item->qq}}</b></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </el-tab-pane>
        <el-tab-pane label="办公室" name="second">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>职位</th>
                    <th>学院</th>
                    <th>年级</th>
                    <th>电话</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($array[2] as $item)
                    @if($i<2)
                    <tr class="success">
                        <th scope="row"><?php echo $i++;?></th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->department}}</td>
                        <td>{{$item->position}}</td>
                        <td>{{$item->college}}</td>
                        <td>{{$item->grade}}</td>
                        <td><b>{{$item->tel}}</b></td>
                    </tr>
                    @else
                    <tr>
                        <th scope="row"><?php echo $i++;?></th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->department}}</td>
                        <td>{{$item->position}}</td>
                        <td>{{$item->college}}</td>
                        <td>{{$item->grade}}</td>
                        <td><b>{{$item->tel}}</b></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </el-tab-pane>
        <el-tab-pane label="技术部" name="third">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>职位</th>
                    <th>学院</th>
                    <th>年级</th>
                    <th>电话</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($array[3] as $item)
                    @if($i<2)
                        <tr class="success">
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @else
                        <tr>
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </el-tab-pane>
        <el-tab-pane label="宣传部" name="fourth">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>职位</th>
                    <th>学院</th>
                    <th>年级</th>
                    <th>电话</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($array[4] as $item)
                    @if($i<2)
                        <tr class="success">
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @else
                        <tr>
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </el-tab-pane>
        <el-tab-pane label="新闻部" name="fifth">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>职位</th>
                    <th>学院</th>
                    <th>年级</th>
                    <th>电话</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($array[5] as $item)
                    @if($i<2)
                        <tr class="success">
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @else
                        <tr>
                            <th scope="row"><?php echo $i++;?></th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->department}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->college}}</td>
                            <td>{{$item->grade}}</td>
                            <td><b>{{$item->tel}}</b></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </el-tab-pane>
        </el-tabs>
    </template>
</div>

</div>
<script src="https://cdn.bootcss.com/vue/2.5.13/vue.min.js"></script>
<script src="{{url('static/contact/js/element.min.js')}}"></script>
<script type="text/javascript">
    new Vue({
        el: '#myVue',
        data() {
            return {
                activeName: 'first',
            }
        },
        methods: {
            handleClick(tab, event) {
            },
        }
    })
</script>
