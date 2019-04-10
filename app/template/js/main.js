
//HTMLCollection.prototype.forEach = Array.prototype.forEach;

//function Popup()

function $(el) {
	return document.querySelector(el);
} // select el

function $$(el) {
	return document.querySelectorAll(el);
} // select node elements

function isEmpty(el) {
	if(el === "" || el === null || el === undefined) {
		return true;
	}
	return false;
}

function isJSON(object) {
	try {
		JSON.parse(object);
		return true;
	} catch(e) {
		return false;
	}
}

function fastEdit(parentElement) {
	$$('.fast_edit').forEach(function(el,i) {
		el.addEventListener('submit', function() {
			formSubmit(parentElement,this, function() {
				location.reload();
			});
		});
	});
}

function BuildElements(parentEl) {
	if(typeof parentEl != 'object') {
		this.parentEl = $(parentEl);
	} else {
		this.parentEl = parentEl;
	}
	this.create = function(childEl,classEl = null,contentEl = null) {
		this.childEl = childEl;
		this.classEl = classEl;
		this.contentEl = contentEl;

		var create = document.createElement(this.childEl);

		if(!isEmpty(classEl)) {
			create.className =  classEl;
		}

		if(!isEmpty(contentEl)) {
			create.textContent =  contentEl;
		}

		this.parentEl.appendChild(create);
		this.lastEl = this.parentEl.lastElementChild;
		return this;
	}

	this.attr = function(key, value) {
		this.parentEl.lastElementChild.setAttribute(key, value);
		return this;
	}
} // builder elements

function request(href,func) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST',href, true);
	xhr.onreadystatechange = function() {
		if(xhr.readyState === 4 && xhr.status === 200) {
			var jsonData = isJSON(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr.responseText;
			func(arg = jsonData);
		}
	}
	xhr.send();
} // Ajax async load




function addImages(event) {
	if(event.target.tagName === 'INPUT') {
		var file = event.target.files[0];
		var reader = new FileReader();
		reader.onload = (function(aImg) {
			switch(file.type) {
				case 'application/pdf':
				return event.target.previousElementSibling.src = '/app/template/img/pdf.svg';
				break;
				case 'video/mp4':
				event.target.nextElementSibling.textContent = 'Файл загружен!';
				return event.target.previousElementSibling.src = '/app/template/img/play_green.svg';
				break;
				default:
				return function(e) {
					event.target.previousElementSibling.src = e.target.result;
				};
				break;
			}
			
		})(file);
		reader.readAsDataURL(file);
	}
}// Dinamic onload images


var popup = {
	open : function(el,func = null) {
		$(el).style.display = 'block';
		new BuildElements('footer').create('div','overflow');
		if(!isEmpty(func)) {
			func();
		}
	},
	close: function(el,func = null) {
		$(el).style.display = 'none';
		$('.overflow').remove();
		if(!isEmpty(func)) {
			func();
		}
	}
} // popup



function progress(element) {
	var progress = new BuildElements(element).create('div','progress','');
	new BuildElements(progress.lastEl).create('img').attr('src','/app/template/img/progress.gif');
}

function formSubmit(el,form,func=null) {
	progress(el);
	var formData = new FormData(form),
	requestTest = new XMLHttpRequest();
	requestTest.open('POST',form.getAttribute('data-href'), true);
	requestTest.onreadystatechange = function() {
		if (requestTest.readyState === 4 && requestTest.status === 200) {
			if(!isEmpty(func)) {
				func();
			}
		}
	}
	requestTest.send(formData);
}

if(!isEmpty($('.validate'))) {
	$('.validate').addEventListener('input', function(e) {

		if(e.target.id === 'login') {
			request('/show?validation=login&login=' + e.target.value,function(arg) {
				if(!isEmpty(arg)) {
					$('.error-login').textContent =  arg;
					$('#login').setCustomValidity(arg);
				} else {
					$('.error-login').textContent = "";
					$('#login').setCustomValidity("");
				}
			});
		}

		if(e.target.id === 'email') {
			request('/show?validation=email&email=' + e.target.value,function(arg) {
				if(!isEmpty(arg)) {
					$('.error-email').textContent =  arg;
					$('#email').setCustomValidity(arg);
				} else {
					$('.error-email').textContent = "";
					$('#email').setCustomValidity("");
				}
			});
		}

		if(e.target.id === 'password_repeat') {
			if($('#password_repeat').value !== $('#password').value) {
				$('.error-password').textContent =  'Пароли не совпадают';
				$('#password_repeat').setCustomValidity('Пароли не совпадают');
			} else {
				$('.error-password').textContent = "";
				$('#password_repeat').setCustomValidity("");
			}
		}
	});
	
}



if(!isEmpty($('#attests'))) {
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			popup.open('#popup');

			request(e.target.href,function(arg) {

				var parentEl = $('#popup');
				if(!isEmpty(arg.video)) {
					new BuildElements('.video')
					.create('video')
					.attr('src',arg.video)
					.attr('controls', true);
				} else {
					var video = document.createElement('p');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.descr)) {
					new BuildElements('.video')
					.create('h3',null,'Описание задания')
					.create('div','descr');
					$('.descr').innerHTML = arg.descr;

				}
				if(!isEmpty(arg.image)) {
					for(var i = 0; i < arg.image; i++) {
						var images = new BuildElements('.files')
						.create('label','attest')
						.attr('for','img' + i);
						new BuildElements(images.lastEl)
						.create('img','attest')
						.attr('src','/app/template/img/photo.svg')
						.create('input','attest')
						.attr('id','img' + i)
						.attr('type','file')
						.attr('name','img[' + i + ']')
						.attr('required',true);
						images.create('div','comment');
						new BuildElements(images.lastEl)
						.create('label','h3','Комментарии')
						.attr('for','comment' + i)
						.create('textarea',null)
						.attr('id','comment' + i)
						.attr('name','comment[' + i + ']');
					}
				}
				new BuildElements('.files')
				.create('input')
				.attr('type','hidden')
				.attr('name','attest_id')
				.attr('value',arg.id)
				.create('input')
				.attr('type','hidden')
				.attr('name','level')
				.attr('value',el.parentElement.parentElement.querySelector('.level').textContent);
			});
		});
	});

	$('.close').addEventListener('click', function() {
		popup.close('#popup', function() {
			$('.video').innerHTML = '';
			$('.files').innerHTML = '';
		});
	});

	$('.files').addEventListener('change', function(e) {
		if(e.target.tagName !== 'TEXTAREA') {
			var photo = e.target.previousElementSibling.src.indexOf('photo.svg'),
			type = e.target.files[0].type;
			if(!isEmpty(e.target.nextElementSibling)) {
				e.target.nextElementSibling.remove();
			}
			switch(type) {
				case 'image/jpeg':
				case 'image/png':
				e.target.setCustomValidity('');
				addImages(e);
				break;
				default:
				new BuildElements(e.target.parentElement).create('span','info');
				e.target.previousElementSibling.src = '/app/template/img/photo_red.svg';
				e.target.setCustomValidity('Неверный формат');
				e.target.nextElementSibling.classList.add('error');
				e.target.nextElementSibling.textContent = 'Загрузите изображение в формате JPG или PNG';
				break;
			}
		}
	});

	$('#popup form').addEventListener('submit', function() {
		formSubmit('#attests',this, function() {
			popup.close('#popup');
			location.reload();
		});
	});
}



if(!isEmpty($('#check'))) {
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			popup.open('#popup');

			request(e.target.href,function(arg) {

				var parentEl = $('#popup'),
				thead = new BuildElements('#popup thead tr'),
				tbody = new BuildElements('#popup tbody tr');

				for(t in arg.title) {
					thead.create('th',null,arg.title[t]);
					if(t === 'result') {
						tbody.create('td',null, arg.descr[t] === null ? '' : arg.descr[t] == 1 ? 'Верно' : 'Неверно');
					} else {
						tbody.create('td', null, arg.descr[t]);
					}

				}
				if(!isEmpty(arg.descr.video)) {
					var video = new BuildElements('.video')
					.create('video')
					.attr('src',arg.descr.video)
					.attr('controls', true)
					.create('h4',null,'Комментарий аттестуемого')
					.create('p',null,arg.descr.attested_comment);
				} else {
					var video = document.createElement('h3');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.image)) {
					var img = new BuildElements('.image_group');
					for(i in arg.image) {
						img.create('div','image');
						var imgWrap = new BuildElements(img.lastEl).create('div','image_wrap');
						var imgImg = new BuildElements(imgWrap.lastEl).create('img').attr('src',arg.image[i].image_file);
						imgWrap.create('div','tools').create('p',null,arg.image[i].attested_comment);
						img.create('div','descript');
						
						new BuildElements(img.lastEl)
						.create('label','result','Неверно')
						.attr('for','img' + i + i)
						.create('input','result','1')
						.attr('id','img' + i + i)
						.attr('type','radio')
						.attr('name','result[' + arg.image[i].id + ']')
						.attr('value','0')
						.create('label','result','Верно')
						.attr('for','img' + i)
						.create('input','result','1')
						.attr('id','img' + i)
						.attr('type','radio')
						.attr('name','result[' + arg.image[i].id + ']')
						.attr('value','1')
						.create('br')
						.create('label','result','Комментарий')
						.attr('for','comment' + i)
						.create('textarea','result')
						.attr('id','comment' + i)
						.attr('name','comment[' + arg.image[i].id + ']');
						//arg.descr.expert_comment
					}
					img.create('label','result','Общий комментарий')
					.attr('for','expert_comment' + i)
					.create('textarea','result')
					.attr('id','expert_comment' + i)
					.attr('name','expert_comment')
					.create('input')
					.attr('type','hidden')
					.attr('name','exam')
					.attr('value',arg.descr.id)
					.create('input')
					.attr('type','hidden')
					.attr('name','level')
					.attr('value',arg.descr.level)
					.create('input')
					.attr('type','hidden')
					.attr('name','attest_id')
					.attr('value',arg.descr.attest_id)
					.create('input')
					.attr('type','hidden')
					.attr('name','login')
					.attr('value',arg.descr.login);
				}
			});
		});
	});

	$('.close').addEventListener('click', function() {
		popup.close('#popup', function() {
			$('.video').innerHTML = '';
			$('.image_group').innerHTML = '';
			$('#popup thead tr').innerHTML = '';
			$('#popup tbody tr').innerHTML = '';
		});
	});


	$('#popup form').addEventListener('submit', function() {
		formSubmit('#check',this, function() {
			popup.close('#popup');
			location.reload();
		});
	});


}


if(!isEmpty($('#results'))) {
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			popup.open('#popup');

			request(e.target.href,function(arg) {

				var parentEl = $('#popup'),
				thead = new BuildElements('#popup thead tr'),
				tbody = new BuildElements('#popup tbody tr');

				for(t in arg.title) {
					thead.create('th',null,arg.title[t]);
					if(t === 'result') {
						tbody.create('td',null, arg.descr[t] === null ? 'Отсутствует' : arg.descr[t] == 1 ? 'Верно' : 'Неверно');
					} else {
						tbody.create('td', null, arg.descr[t]);
					}

				}
				if(!isEmpty(arg.descr.video)) {
					var video = new BuildElements('.video')
					.create('video')
					.attr('src',arg.descr.video)
					.attr('controls', true)
					.create('h4',null,'Комментарий аттестуемого')
					.create('p',null,arg.descr.attested_comment)
					.create('h4',null,'Комментарии экспертов')
					.create('div','table');
					var expTable = new BuildElements(video.lastEl);
					for(var i = 0; i < arg.expert_comment.length; i++) {
						expTable.create('div','tr');
						new BuildElements(expTable.lastEl)
						.create('div','td','Эксперт №' + (i + 1))
						.create('div','td',arg.expert_comment[i].expert_comment);
					}

				} else {
					var video = document.createElement('h3');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.image)) {
					var img = new BuildElements('.image_group');
					for(var i = 0; i < arg.image.length; i++) {
						img.create('div','image');
						var imgWrap = new BuildElements(img.lastEl).create('div','image_wrap');
						
						new BuildElements(imgWrap.lastEl).create('img').attr('src',arg.image[i].image_file);

						imgWrap.create('div','tools').create('p',null,arg.image[i].attested_comment);
						img.create('div','descript');
						var imgWrap = new BuildElements(img.lastEl).create('div','table');
						var imgTable = new BuildElements(imgWrap.lastEl).create('div','tr');
						var imgWrapTr = new BuildElements(imgTable.lastEl);
						if(!isEmpty(arg.image[i].result)) {
							imgWrapTr.create('div','th','№ эксперта')
							.create('div','th','Результат')
							.create('div','th','Комментарий');
							for(var j = 0; j < arg.image[i].result.length; j++) {
								imgTable.create('div','tr');
								var tr = new BuildElements(imgTable.lastEl)
								.create('div','td', j + 1)
								.create('div','td',arg.image[i].result[j].result === null ? '' : arg.image[i].result[j].result == 1 ? 'Верно' : 'Неверно')
								.create('div','td',arg.image[i].result[j].expert_comment);
							}
						}
						
					}
				}
			});
		});
	});

	$('.close').addEventListener('click', function() {
		popup.close('#popup', function() {
			$('.video').innerHTML = '';
			$('.image_group').innerHTML = '';
			$('#popup thead tr').innerHTML = '';
			$('#popup tbody tr').innerHTML = '';
		});
	});


}


if(!isEmpty($('#users'))) {
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			popup.open("#popup");

			request(e.target.href,function(arg) {
				var parentEl = $('#popup');
				var data = new BuildElements('.block_data');
				for(i in arg.descr) {
					data.create('label',null,arg.title[i]).attr('for',i);

					switch(i) {
						case 'role':
						data.create('select').attr('id',i).attr('name',i);
						childData = new BuildElements(data.lastEl);
						for(j in arg.role) {
							childData.create('option',null,arg.role[j].name).attr('value',arg.role[j].id);
							if(arg.role[j].name === arg.descr.role_name) {
								childData.attr('selected', true);
							}
							
						}

						break;
						case 'email' :
						data.create('input')
						.attr('id',i)
						.attr('name',i)
						.attr('type','email')
						.attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '');
						break;
						case 'medic':
						case 'dt_insert':

						data.create('input')
						data.attr('id',i)
						data.attr('name',i)
						data.attr('type','checkbox');

						if(i === 'medic') {
							//data.attr('disabled',true);
							arg.descr[i] == 1 ? data.attr('checked',true) : null;
						}
						if(i === 'dt_insert' && !isEmpty(arg.descr[i])) {
							data.attr('checked',true);
						}
						break;
						default :
						data.create('input')
						.attr('id',i)
						.attr('name',i)
						.attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '')
						.attr('readonly', true);
						break;
					}
				}
				if(!isEmpty(arg.docs)) {
					var docs = new BuildElements('.image_docs'),
					history = new BuildElements('.history'),
					count = 0
					
					for(i in arg.docs.doc) {
						if(isEmpty(arg.docs.doc[i].result_check)) {
							docs.create('div','image');
							var docsWrap = new BuildElements(docs.lastEl).create('div','image_wrap');
							var docsImg = new BuildElements(docsWrap.lastEl).create('img').attr('src',arg.docs.doc[i].doc_file);
							docsWrap.create('div','tools').create('p',null,arg.docs.doc[i].doc_name);
							docs.create('div','descript');

							var docsWrap = new BuildElements(docs.lastEl)
							.create('label','result','Отклонено')
							.attr('for','img' + i + i)
							.create('input','result','1')
							.attr('id','img' + i + i)
							.attr('type','radio')
							.attr('name','result[' + arg.docs.doc[i].id + ']')
							.attr('value','0')
							.create('label','result','Принято')
							.attr('for','img' + i)
							.create('input','result','1')
							.attr('id','img' + i)
							.attr('type','radio')
							.attr('name','result[' + arg.docs.doc[i].id + ']')
							.attr('value','1')
							.create('br')
							.create('label','result','Комментарий')
							.attr('for','comment' + i)
							.create('textarea','result')
							.attr('id','comment' + i)
							.attr('name','comment[' + arg.docs.doc[i].id + ']');
						} else {
							if(count < 1) {
								history.create('div','thead');
								var tHead = new BuildElements(history.lastEl).create('div','tr');
								var tr = new BuildElements(tHead.lastEl);
								for(var t in arg.docs.title) {
									tr.create('div','th',arg.docs.title[t]);
								}
							}
							history.create('div','tbody');
							var tBody = new BuildElements(history.lastEl);
							if(arg.docs.doc[i].result == 1) {
								tBody.create('div','tr green');
							} else {
								tBody.create('div','tr red');
							}
							var tr = new BuildElements(tBody.lastEl)
							.create('div','td',arg.docs.doc[i].doc_name)
							.create('div','td',arg.docs.doc[i].dt_insert)
							.create('div','td',arg.docs.doc[i].dt_check)
							.create('div','td',arg.docs.doc[i].login_check)
							.create('div','td',arg.docs.doc[i].result_check)
							.create('div','td',arg.docs.doc[i].comment_check)
							.create('div','td');
							var tdImg = new BuildElements(tr.lastEl).create('div','image');
							var docsWrap = new BuildElements(tdImg.lastEl).create('div','image_wrap');
							var docsImg = new BuildElements(docsWrap.lastEl).create('img').attr('src',arg.docs.doc[i].doc_file);
							docsWrap.create('div','tools');
							count++;
						}
					}

					docs.create('input')
					.attr('type','hidden')
					.attr('name','docs')
					.attr('value',arg.descr.id);
				}
				
				
			});
});
});

$('.close').addEventListener('click', function() {
	popup.close('#popup', function() {
		$('.block_data').innerHTML = '';
		$('.image_docs').innerHTML = '';
		$('.history').innerHTML = '';
	});
});


$('#popup form').addEventListener('submit', function() {
	formSubmit('#users',this, function() {
		popup.close('#popup');
		location.reload();
	});
});

fastEdit('#users');



}

if(!isEmpty($('.expert_purpose'))) {

	$$('.expert_purpose').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			request(e.target.href,function(arg) {
				$$('#purpose_expert input[type="checkbox"]').forEach(function(element, idx) {
					if(arg.indexOf(element.value) !== -1) {
						element.checked = true;
					}
				});
			});
			popup.open("#expert");
			$('#login_name').value = el.getAttribute('data-login'); 
		});
	});

	$('#purpose_expert').addEventListener('submit', function() {
		formSubmit('#users',this, function() {
			popup.close('#expert');
		location.reload();
	});
	});

	$('.close-expert').addEventListener('click', function() {
		popup.close('#expert', function() {
		});
		$$('#purpose_expert input[type="checkbox"]').forEach(function(element, idx) {
			element.checked = false;
		});
	});
}


function addVideo(parent) {
	var video = new BuildElements(parent).create('div','files');
	var files = new BuildElements(video.lastEl).create('label').attr('for','video');
	var videoFile = new BuildElements(files.lastEl)
	.create('img')
	.attr('src','/app/template/img/play.svg')
	.create('input')
	.attr('id','video')
	.attr('type','file')
	.attr('name','video')
	.create('span','info','Загрузите видео в формате MP4');
}

function filesChange() {
	$('.files').addEventListener('change', function(event) {
		var photo = event.target.previousElementSibling.src.indexOf('/app/template/img/play.svg'),
		type = event.target.files[0].type;
		if(type === 'video/mp4') {
			event.target.setCustomValidity('');
			addImages(event);
		} else {
			event.target.setCustomValidity('Неверный формат! Загрузите видео в формате MP4');
			this.querySelector('img').src = '/app/template/img/play_red.svg';
			this.querySelector('.info').textContent = 'Неверный формат! Загрузите видео в формате MP4';
		}
	});
}




if(!isEmpty($('#events'))) {
	var editor = CKEDITOR.replace('descr',{'filebrowserBrowseUrl':'/kcfinder/browse.php?type=files',
		'filebrowserImageBrowseUrl':'/app/template/js/kcfinder/browse.php?type=images',
		'filebrowserFlashBrowseUrl':'/app/template/js/kcfinder/browse.php?type=flash',
		'filebrowserUploadUrl':'/app/template/js/kcfinder/upload.php?type=files',
		'filebrowserImageUploadUrl':'/app/template/js/kcfinder/upload.php?type=images',
		'filebrowserFlashUploadUrl':'/app/template/js/kcfinder/upload.php?type=flash'});
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			$('#popup form').setAttribute('data-href','/events/edit?action=update&full=true');
			popup.open('#popup');
			request(e.target.href,function(arg) {
				var parentEl = $('#popup');
				
				var data = new BuildElements('.block_data');
				for(i in arg.descr) {
					if(i !== 'video' && i !== 'descr') {
						data.create('label',null,arg.title[i]).attr('for',i);
					}
					switch(i) {
						case 'descr' :
						editor.setData(arg.descr.descr);
						break;
						case 'modality':
						case 'ssapm':
						data.create('select').attr('id',i).attr('name',i);
						childData = new BuildElements(data.lastEl);
						for(j in arg[i]) {
							childData.create('option',null,arg[i][j].name).attr('value',arg[i][j].id);
							if(arg[i][j].id === arg.descr[i]) {
								childData.attr('selected',true);
							}
						}

						break;
						case 'public':
						data.create('input').attr('id',i).attr('name',i).attr('type','checkbox');
						if(arg.descr[i] == 1) {
							data.attr('checked',true);
						}
						break;
						case 'video':
						if(!isEmpty(arg.descr[i])) {
							new BuildElements('.block_video').create('video').attr('src',arg.descr[i]).attr('controls', true);
						} else {
							var video = document.createElement('h3');
							video.textContent = 'Видео остутствует!';
							parentEl.querySelector('.block_video').appendChild(video);
						}
						addVideo($('.block_video'));
						break;
						default :
						data.create('input');
						switch(i) {
							case 'image_max_count' :
							case 'price_level1_first' :
							case 'price_level2_first' :
							case 'price_level1_next' :
							case 'price_level2_next' :
							case 'active_days_level1' :
							case 'active_days_level2' :
							data.attr('type','number').attr('min',0);
							break;
							case 'id':
							data.attr('readonly', true);
						}
						data.attr('id',i).attr('name',i).attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '');
						break;
					}
				}
				
				if(!isEmpty(arg.docs)) {
					var docs = new BuildElements('.block_docs');
					for(i in arg.docs) {
						docs.create('div','image');
						var docsWrap = new BuildElements(docs.lastEl).create('div','image_wrap');
						new BuildElements(docsWrap.lastEl).create('img').attr('src',arg.docs[i].doc_file);
						docsWrap.create('div','tools');
					}
				}
				filesChange();
			});

		});
	});
	editor.on('change', function(event) {
		$('#descr').value = event.editor.getData();
	});

	$$('.del').forEach(function(el, i) {
		el.addEventListener('click', function(event) {
			event.preventDefault();
			var xhr = new XMLHttpRequest();
			xhr.open('POST',el.href,false);
			xhr.send();
			if(!isEmpty(xhr.responseText)) {
				el.nextElementSibling.classList.add(xhr.responseText);
				el.nextElementSibling.textContent = 'По данному случаю проводились аттестации!'
			}
			setTimeout(function() {
				location.reload();
			}, 1000);
		});
	});


	$('.close').addEventListener('click', function() {
		popup.close('#popup', function() {
			$('.block_data').innerHTML = '';
			$('.block_video').innerHTML = '';
			editor.setData('');
		});
	});

	$('#popup form').addEventListener('submit', function() {
		formSubmit('#events',this, function() {
			popup.close('#popup');
			location.reload();
		});
	});

	fastEdit('#events');

	$('.new_events').addEventListener('click',function(e) {
		e.preventDefault();
		$('#popup form').setAttribute('data-href','/events/edit?action=add&full=true');
		popup.open('#popup');
		request(e.target.href,function(arg) {
			addVideo($('.block_video'));
			filesChange();
			var data = new BuildElements('.block_data');
			for(i in arg.title) {
				if(i !== 'id') {
					data.create('label',null,arg.title[i]).attr('for',i);
				}
				switch(i) {
					case 'id':
					break;
					case 'descr':
					break;
					case 'modality':
					case 'ssapm':
					data.create('select').attr('id',i).attr('name',i);
					childData = new BuildElements(data.lastEl);
					for(j in arg[i]) {
						childData.create('option',null,arg[i][j].name).attr('value',arg[i][j].id);
					}

					break;
					case 'public':
					data.create('input').attr('id',i).attr('name',i).attr('type','checkbox');
					break;
					case 'video':
					addVideo($('.block_video'));
					break;
					default :
					data.create('input');
					switch(i) {
						case 'image_max_count' :
						case 'price_level1_first' :
						case 'price_level2_first' :
						case 'price_level1_next' :
						case 'price_level2_next' :
						case 'active_days_level1' :
						case 'active_days_level2' :
						data.attr('type','number').attr('min',0);
						break;
						case 'id':
						data.attr('readonly', true);
					}
					data.attr('id',i).attr('name',i);
					break;
				}
			}
		});
	});
}


//  View Image

if(!isEmpty($('.image_group'))) {
	$('.image_group').addEventListener('click', function(e) {
		var parent = e.target.parentElement.parentElement;
		if(e.target.tagName === 'IMG') {
			parent.classList.add('active');

			new BuildElements('.image.active .tools').create('i','close').create('i','full').create('i','zoom');
		}
	});

	$('.image_group').addEventListener('click', function(event) {

		if(event.target.tagName === 'I') {

			event.target.parentElement.previousElementSibling.className = 'image_wrap';
			$$('.image.active .tools i').forEach(function(i) {
				i.classList.remove('active');
			});
			if($('.zoom_img')) {
				$('.image.active .image_wrap').removeChild($('.zoom_img'));
			}

			if(event.target.className !== 'close') {
				event.target.parentElement.previousElementSibling.className = 'image_wrap ' + event.target.className;
				event.target.classList.add('active');
			} else {
				$('.image.active').classList.remove('active');
					//this.parentElement.innerHTML = '';
				}
			}
		});
	$('.image_group').addEventListener('mouseover', function(e) {
		if(e.target.tagName	=== 'IMG' && e.target.parentElement.className === 'image_wrap zoom') {
			var elZoom = new BuildElements('.image.active .image_wrap').create('div','zoom_img');
			var zoomImg = new BuildElements(elZoom.lastEl).create('img').attr('src', $('.image.active .image_wrap img').src);
		}
	});
	$('.image_group').addEventListener('mouseout', function(e) {
		if(e.target.tagName	=== 'IMG' && e.target.parentElement.className === 'image_wrap zoom') {
			if($('.zoom_img')) {
				$('.image.active .image_wrap').removeChild($('.zoom_img'));
			}
		}
	});
	$('.image_group').addEventListener('mousemove', function(e) {

		if(e.target.tagName	=== 'IMG' && e.target.parentElement.className === 'image_wrap zoom') {
			var activeImage = $('.image_wrap.zoom img'),
			loopParent 	= $('.zoom_img'),
			loop 		= $('.zoom_img img'),
			heightNum = loop.height/activeImage.clientHeight,
			widthNum  = loop.width/activeImage.clientWidth;

			if((e.offsetX * widthNum) > (loop.width - (loopParent.clientWidth/2))) {
				loop.style.left = -(loop.width - loopParent.clientWidth) + 'px';
			} else if((e.offsetX * widthNum) < loopParent.clientWidth/2) {
				loop.style.left = 0;
			} else {
				loop.style.left = -(e.offsetX * widthNum) + (loopParent.clientWidth/2) + 'px';
			}

			if((e.offsetY * heightNum)  > (loop.height - (loopParent.clientHeight/2))) {
				loop.style.top = -(loop.height - loopParent.clientHeight) + 'px';
			} else if((e.offsetY * heightNum) < loopParent.clientHeight/2) {
				loop.style.top = 0;
			} else {
				loop.style.top = -(e.offsetY * heightNum) + (loopParent.clientHeight/2) + 'px';
			}
		}
	});
}


if(!isEmpty($('#directory'))) {
	$('#directory').addEventListener('click', function(e) {

		var	parentEl = e.target.parentElement.parentElement;

		if(e.target.tagName === 'I' &&  !isEmpty(parentEl.querySelector('input').value)) {
			if(e.target.classList.contains('add')) {
				var tr = new BuildElements(parentEl.parentElement.previousElementSibling).create('div','tr');
				var td = new BuildElements(tr.lastEl).create('div','td');
				var inp = new BuildElements(td.lastEl)
				.create('input')
				.attr('type','text')
				.attr('value',parentEl.querySelector('input').value)
				.attr('name',parentEl.querySelector('input').getAttribute('data-name') + '[new][]');
				var td = new BuildElements(tr.lastEl).create('div','td');
				var btn = new BuildElements(td.lastEl).create('i','button edit del','-');
				parentEl.querySelector('input').value = '';
			} else if(e.target.classList.contains('del')) {
				request(e.target.getAttribute('data-href'), function() {
					var	inp = parentEl.querySelector('input');
					if(!isEmpty(parentEl.querySelector('.error'))) {
						parentEl.querySelector('.error').remove();
					}
					if(arg) {
						var errorMessage = new BuildElements(inp.parentElement);
						inp.classList.add('red');
						errorMessage.create('span','error','Это элемент имеет связь, удаление невозможно!');
						setTimeout(function() {
							inp.classList.remove('red');
							parentEl.querySelector('.error').remove();
						},3000);
					} else {
						
						inp.setAttribute('name',inp.getAttribute('name').replace(/\[\w{0,}\]/,'[del]'));
					}
				});
				
				/*parentEl.classList.add('hidden');
				e.target.parentElement.remove();*/
			}
		}
	});

	$$('#directory form').forEach(function(el, i) {
		el.addEventListener('submit', function() {
			formSubmit('#directory',this, function() {
				location.reload();
			});
		});
	});
}



if(!isEmpty($('#personal'))) {
	if(!isEmpty($('#personal_data'))) {
		$('#personal_data').addEventListener('submit', function() {
			formSubmit('#personal_data',this, function() {
				location.reload();
			});
		});
	}

	if(!isEmpty($('#password_update'))) {
		$('#password_update').addEventListener('submit', function() {
			formSubmit('#password_update',this, function() {
				location.reload();
			});
		});
	}
	if(!isEmpty($('.files'))) {
		var images = new BuildElements('.files');
		var count = 0;
		function addFormDoc() {
			images.create('div','doc');
			var doc = new BuildElements(images.lastEl)
			.create('label','document')
			.attr('for','img' + count);
			var childImages = new BuildElements(doc.lastEl)
			.create('img')
			.attr('src','/app/template/img/photo.svg')
			.create('input','image')
			.attr('id','img' + count)
			.attr('type','file');
			if($('.files').childElementCount <= 1) {
				childImages.attr('required',true);
			}
			doc.create('div','comment');
			new BuildElements(doc.lastEl)
			.create('label','h3','Наименование документа')
			.attr('for','comment' + count)
			.create('textarea','docs_name')
			.attr('id','comment' + count);

			//childImages.attr('name','comment[]');
			count++;
		}
		addFormDoc();
		$('.files').addEventListener('change', function(e) {

			if(e.target.tagName !== 'TEXTAREA') {
				var photo = e.target.previousElementSibling.src.indexOf('photo.svg'),
				type = e.target.files[0].type;
				if(!isEmpty(e.target.nextElementSibling)) {
					e.target.nextElementSibling.remove();
				}
				switch(type) {
					case 'image/jpeg':
					case 'image/png':
					e.target.setCustomValidity('');
					addImages(e);
					var parentEl = e.target.parentElement.parentElement;
					parentEl.querySelector('.image').setAttribute('name','img[]');
					parentEl.querySelector('.docs_name').setAttribute('name','comment[]');
					if(photo !== -1) {
						e.target.parentElement.parentElement.querySelector('textarea').setAttribute('required',true);
						addFormDoc();
					}
					break;
					default:
					var error = new BuildElements(e.target.parentElement).create('span','info');
					e.target.previousElementSibling.src = '/app/template/img/photo_red.svg';
					e.target.setCustomValidity('Неверный формат');
					e.target.nextElementSibling.classList.add('error');
					e.target.nextElementSibling.textContent = 'Загрузите изображение в формате JPG или PNG';
					break;
				}
			}
		});

		$('#education_docs').addEventListener('submit', function() {
			formSubmit('#education_docs',this, function() {
				location.reload();
			});
		});

		$('.block_docs').addEventListener('click', function(e) {
			if(e.target.tagName === 'IMG') {
				$('.tools').innerHTML = '';
				popup.open('#popup');
				$('.image_group img').click();
				$('.image_wrap img').src = e.target.src;
				$('.image_group .tools .close').addEventListener('click', function(event) {
					popup.close('#popup');
				});
			}

		});
/*
		if(!isEmpty($('.image_group .tools i'))) {

		}*/
	}
}

if(!isEmpty($('#setting'))) {
	$$('form').forEach(function(el, i) {
		el.addEventListener('submit', function() {
			formSubmit('form',this, function() {
				location.reload();
			});
		});
	});
}




$$('input[type="tel"]').forEach(function(el, i) {
	el.addEventListener('input', function(e) {
		switch(e.target.selectionEnd) {
			case 1 : 
			this.value = this.value.replace(/(^\d{1,3})/,'+7 ($1');
			case 8 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})/,'$1 ($2) ');
			break;
			case 12 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})\)\s(\d{3})/,'$1 ($2) $3');
			break;
			case 13 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})\)\s(\d{3})/,'$1 ($2) $3-');
			break;
			case 15 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})\)\s(\d{3})-(\d{2})/,'$1 ($2) $3-$4');
			break;
			case 16 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})\)\s(\d{3})-(\d{2})/,'$1 ($2) $3-$4-');
			break;
			case 18 : 
			this.value = this.value.replace(/(^\+7)\s\((\d{3})\)\s(\d{3})-(\d{2})-(\d{2})/,'$1 ($2) $3-$4-$5');
			break;
		}
	});
	
});

if(!isEmpty($('.filter'))) {
	var FilterArray = {};
	$('.filter').addEventListener('input', function(e) {
		if(e.target.hasAttribute('data-find')) {
			var key = e.target.getAttribute('data-find'),
			value = e.target.type === "checkbox" ? e.target.checked : e.target.value.toLowerCase();
			FilterArray[key] = value;
		}
		for(var el in FilterArray) {
			$$('.' + el).forEach(function(element) {
				var bool = element.type === "checkbox" ? FilterArray[el] !== element.checked :  element.value.toLowerCase().indexOf(FilterArray[el]) === -1;

				if(bool) {
					element.parentElement.classList.add('hide');
				} else {
					element.parentElement.classList.remove('hide');
				}

			});
		}
		$$('.tbody .tr').forEach(function(tr) {
			var quanHide = tr.querySelectorAll('.hide').length;
			if(quanHide > 0) {
				tr.classList.add('hidden');
			} else {
				tr.classList.remove('hidden');
			}
		});
	});


	$('.reset').addEventListener('click', function(e) {
		this.parentElement.parentElement.querySelectorAll('.find').forEach(function(el) {
			if(el.firstElementChild.type === 'checkbox') {
				el.firstElementChild.checked = false;
			} else {
				el.firstElementChild.value = '';
			}
			$$('.tbody .tr').forEach(function(tr) {
				tr.classList.remove('hidden');
			});
		});
	});
} // filter