<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;

$this->title = '图片下载 - 爱阅技术团队';
echo Html::cssFile('frontend/web/statics/css/crawl.css');
echo Html::jsFile('frontend/web/statics/js/jquery.js');

?>
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<div id="crawl-app">
	<div class="crawl-wrap">
		<div class="crawl-container">
			<div class="crawl-header">
				<div class="crawl-title">
					<el-button type="primary" @click="dialogFormVisible = true">新建任务</el-button>

					<el-dialog title="任务信息" :visible.sync="dialogFormVisible">
					  <el-form :model="form">
					    <el-form-item label="任务名称" :label-width="formLabelWidth">
					      <el-input v-model="form.title" autocomplete="off"></el-input>
					    </el-form-item>
					    <el-form-item label="任务链接" :label-width="formLabelWidth">
					      <el-input v-model="form.url" autocomplete="off"></el-input>
					    </el-form-item>
					  </el-form>
					  <div slot="footer" class="dialog-footer">
					    <el-button @click="dialogFormVisible = false">取 消</el-button>
					    <el-button type="primary" @click="submitForm">确 定</el-button>
					  </div>
					</el-dialog>
				</div>
			</div>
			<div class="crawl-list">
				<template>
				  <el-table
				    :data="schedules"
				    stripe
				    style="width: 100%">
				    <el-table-column
				      prop="title"
				      label="任务"
				      width="180"
				      show-overflow-tooltip="true">
				    </el-table-column>
				    <el-table-column
				      prop="url"
				      label="链接"
				      width="400"
				      show-overflow-tooltip="true"
				      v-on:click="goToUrl">
				    </el-table-column>
				    <el-table-column
				      prop="status"
				      label="状态"
				      align="right">
				    </el-table-column>
				  </el-table>
				</template>
			</div>
		</div>
	</div>
</div>
<!-- import Vue before Element -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
var app = new Vue({
	el: '#crawl-app',
	data: {
	// currentRoute: window.location.pathname
        schedules: null,
        dialogFormVisible: false,
        form: {
          title: null,
          url: null,
        },
        formLabelWidth: '120px'
    },
    created: function() {
    	this.getList()
    },
    methods: {
    	goToUrl: function() {
    		console.log(this)
    	},
    	submitForm: function() {
    		var self = this
    		var re = new RegExp(/(http|https):\/\/([\w.]+\/?)\S*/);
    		if (re.test(self.form.url) == false) {
    			self.$message.error('链接格式错误');
    			self.dialogFormVisible = false
    			self.form.title = null
    			self.form.url = null
    			return;
    		}
    		axios.post('/api/create', {
    			'title': self.form.title,
    			'url': self.form.url
    		})
          	.then(function (response) {
            	var data = response.data
            	if (data.code === 0) {
            		self.$message({
			          message: '任务创建成功',
			          type: 'success'
			        });
            		self.getList()
            	}
        	})
    		self.dialogFormVisible = false
    		self.form.title = null
    		self.form.url = null
    	},
    	getList: function() {
    		var self = this
    		axios.get('/api/schedule')
	          .then(function (response) {
	            self.schedules = response.data.data;
	            var m = new Map([["2", "已完成"], ["1", "进行中"], ["0", "未开始"]]);
	            for (var i = self.schedules.length - 1; i >= 0; i--) {
	            	self.schedules[i]['status'] = m.get(self.schedules[i]['status'])
	            }
	        })
    	}
    },
	computed: {
		// ViewComponent () {
		//   return routes[this.currentRoute] || NotFound
		// }
	},
	// render (h) { return h(this.ViewComponent) }
})
</script>