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
	this.parentEl = parentEl;
	
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
	}

	this.attr = function(key, value) {
		this.parentEl.lastElementChild.setAttribute(key, value);
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
		var newEl = new BuildElements($('footer'));
		newEl.create('div','overflow');
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
	var progress = new BuildElements($(element));
	progress.create('div','progress','');
	var progressChild = new BuildElements(progress.lastEl);
	progressChild.create('img');
	progressChild.attr('src','/app/template/img/progress.gif');
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
			request('http://medexpert2.ru/account/registr/show?validation=login&login=' + e.target.value,function(arg) {
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
			request('http://medexpert2.ru/account/registr/show?validation=email&email=' + e.target.value,function(arg) {
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

					var video = new BuildElements($('.video'));
					video.create('video');
					video.attr('src',arg.video);
					video.attr('controls', true);
				} else {
					var video = document.createElement('p');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.descr)) {
					var descr = new BuildElements($('.video'));
					descr.create('h3',null,'Описание задания');
					descr.create('p','descr',arg.descr);
					//CKEDITOR.replace('message');

				}
				if(!isEmpty(arg.image)) {
					for(var i = 0; i < arg.image; i++) {
						var images = new BuildElements($('.files'));
						images.create('label','attest');
						images.attr('for','img' + i);
						var childImages = new BuildElements(images.lastEl);
						childImages.create('img','attest');
						childImages.attr('src','/app/template/img/photo.svg');
						childImages.create('input','attest');
						childImages.attr('id','img' + i);
						childImages.attr('type','file');
						childImages.attr('name','img[' + i + ']');
						childImages.attr('required',true);
						images.create('div','comment');
						var childImages = new BuildElements(images.lastEl);
						childImages.create('label','h3','Комментарии');
						childImages.attr('for','comment' + i);
						childImages.create('textarea',null);
						childImages.attr('id','comment' + i);
						childImages.attr('name','comment[' + i + ']');
					}
				}
				var attestId = new BuildElements($('.files'));
				attestId.create('input');
				attestId.attr('type','hidden');
				attestId.attr('name','attest_id');
				attestId.attr('value',arg.id);

				attestId.create('input');
				attestId.attr('type','hidden');
				attestId.attr('name','level');
				attestId.attr('value',el.parentElement.parentElement.querySelector('.level').textContent);
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
				var error = new BuildElements(e.target.parentElement);
				error.create('span','info');
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
				thead = new BuildElements($('#popup thead tr')),
				tbody = new BuildElements($('#popup tbody tr'));

				for(t in arg.title) {
					thead.create('th',null,arg.title[t]);
					if(t === 'result') {
						tbody.create('td',null, arg.descr[t] === null ? '' : arg.descr[t] == 1 ? 'Верно' : 'Неверно');
					} else {
						tbody.create('td', null, arg.descr[t]);
					}

				}
				if(!isEmpty(arg.descr.video)) {
					var video = new BuildElements($('.video'));
					video.create('video');
					video.attr('src',arg.descr.video);
					video.attr('controls', true);
					video.create('h4',null,'Комментарий аттестуемого');
					video.create('p',null,arg.descr.attested_comment);
				} else {
					var video = document.createElement('h3');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.image)) {
					var img = new BuildElements($('.image_group'));
					for(i in arg.image) {
						img.create('div','image');
						var imgWrap = new BuildElements(img.lastEl);
						imgWrap.create('div','image_wrap');
						var imgImg = new BuildElements(imgWrap.lastEl);
						imgImg.create('img');
						imgImg.attr('src',arg.image[i].image_file);
						imgWrap.create('div','tools');
						imgWrap.create('p',null,arg.image[i].attested_comment);
						img.create('div','descript');
						
						var imgWrap = new BuildElements(img.lastEl);
						imgWrap.create('label','result','Неверно');
						imgWrap.attr('for','img' + i + i);
						imgWrap.create('input','result','1');
						imgWrap.attr('id','img' + i + i);
						imgWrap.attr('type','radio');
						imgWrap.attr('name','result[' + arg.image[i].id + ']');
						imgWrap.attr('value','0');

						imgWrap.create('label','result','Верно');
						imgWrap.attr('for','img' + i);
						imgWrap.create('input','result','1');
						imgWrap.attr('id','img' + i);
						imgWrap.attr('type','radio');
						imgWrap.attr('name','result[' + arg.image[i].id + ']');
						imgWrap.attr('value','1');

						imgWrap.create('br');
						imgWrap.create('label','result','Комментарий');
						imgWrap.attr('for','comment' + i);
						imgWrap.create('textarea','result');
						imgWrap.attr('id','comment' + i);
						imgWrap.attr('name','comment[' + arg.image[i].id + ']');
						//arg.descr.expert_comment
					}
					img.create('label','result','Общий комментарий');
					img.attr('for','expert_comment' + i);
					img.create('textarea','result');
					img.attr('id','expert_comment' + i);
					img.attr('name','expert_comment');

					img.create('input');
					img.attr('type','hidden');
					img.attr('name','exam');
					img.attr('value',arg.descr.id);

					img.create('input');
					img.attr('type','hidden');
					img.attr('name','level');
					img.attr('value',arg.descr.level);

					img.create('input');
					img.attr('type','hidden');
					img.attr('name','attest_id');
					img.attr('value',arg.descr.attest_id);

					img.create('input');
					img.attr('type','hidden');
					img.attr('name','login');
					img.attr('value',arg.descr.login);
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
				thead = new BuildElements($('#popup thead tr')),
				tbody = new BuildElements($('#popup tbody tr'));

				for(t in arg.title) {
					thead.create('th',null,arg.title[t]);
					if(t === 'result') {
						tbody.create('td',null, arg.descr[t] === null ? 'Отсутствует' : arg.descr[t] == 1 ? 'Верно' : 'Неверно');
					} else {
						tbody.create('td', null, arg.descr[t]);
					}

				}
				if(!isEmpty(arg.descr.video)) {
					var video = new BuildElements($('.video'));
					video.create('video');
					video.attr('src',arg.descr.video);
					video.attr('controls', true);
					video.create('h4',null,'Комментарий аттестуемого');
					video.create('p',null,arg.descr.attested_comment);
					video.create('h4',null,'Комментарии экспертов');
					video.create('div','table');
					var expTable = new BuildElements(video.lastEl);
					for(var i = 0; i < arg.expert_comment.length; i++) {
						expTable.create('div','tr');
						var expTableTr = new BuildElements(expTable.lastEl);
						expTableTr.create('div','td','Эксперт №' + (i + 1));
						expTableTr.create('div','td',arg.expert_comment[i].expert_comment);
					}

				} else {
					var video = document.createElement('h3');
					video.textContent = 'Видео остутствует!';
					parentEl.querySelector('.video').appendChild(video);
				}

				if(!isEmpty(arg.image)) {
					var img = new BuildElements($('.image_group'));
					for(var i = 0; i < arg.image.length; i++) {
						img.create('div','image');
						var imgWrap = new BuildElements(img.lastEl);
						imgWrap.create('div','image_wrap');
						var imgImg = new BuildElements(imgWrap.lastEl);
						imgImg.create('img');
						imgImg.attr('src',arg.image[i].image_file);
						imgWrap.create('div','tools');
						imgWrap.create('p',null,arg.image[i].attested_comment);
						img.create('div','descript');
						var imgWrap = new BuildElements(img.lastEl);
						imgWrap.create('div','table');
						var imgTable = new BuildElements(imgWrap.lastEl);
						imgTable.create('div','tr');
						var imgWrapTr = new BuildElements(imgTable.lastEl);
						if(!isEmpty(arg.image[i].result)) {
							imgWrapTr.create('div','th','№ эксперта');
							imgWrapTr.create('div','th','Результат');
							imgWrapTr.create('div','th','Комментарий');
							for(var j = 0; j < arg.image[i].result.length; j++) {
								imgTable.create('div','tr');
								var tr = new BuildElements(imgTable.lastEl);
								tr.create('div','td', j + 1);
								tr.create('div','td',arg.image[i].result[j].result === null ? '' : arg.image[i].result[j].result == 1 ? 'Верно' : 'Неверно');
								tr.create('div','td',arg.image[i].result[j].expert_comment);
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
			popup.open('#popup');

			request(e.target.href,function(arg) {
				var parentEl = $('#popup');
				
				var data = new BuildElements($('.block_data'));
				for(i in arg.descr) {
					data.create('label',null,arg.title[i]);
					data.attr('for',i);

					switch(i) {
						case 'role_name':
						data.create('select');
						data.attr('id',i);
						data.attr('name',i);
						childData = new BuildElements(data.lastEl);
						for(j in arg.role) {
							childData.create('option',null,arg.role[j].name);
							childData.attr('value',arg.role[j].name);
							if(arg.role[j].name === arg.descr.role_name) {
								childData.attr('selected', true);
							}
							
						}

						break;
						case 'email' :
						data.create('input');
						data.attr('id',i);
						data.attr('name',i);
						data.attr('type','email');
						data.attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '');
						break;
						case 'medic':
						case 'dt_insert':

						data.create('input');
						data.attr('id',i);
						data.attr('name',i);
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
						data.create('input');
						data.attr('id',i);
						data.attr('name',i);
						data.attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '');
						data.attr('readonly', true);
						break;
					}
				}
				if(!isEmpty(arg.docs)) {
					var docs = new BuildElements($('.image_docs')),
					history = new BuildElements($('.history')),
					count = 0
					
					for(i in arg.docs.doc) {
						if(isEmpty(arg.docs.doc[i].result_check)) {
							docs.create('div','image');
							var docsWrap = new BuildElements(docs.lastEl);
							docsWrap.create('div','image_wrap');
							var docsImg = new BuildElements(docsWrap.lastEl);
							docsImg.create('img');
							docsImg.attr('src',arg.docs.doc[i].doc_file);
							docsWrap.create('div','tools');
							docsWrap.create('p',null,arg.docs.doc[i].doc_name);
							docs.create('div','descript');

							var docsWrap = new BuildElements(docs.lastEl);
							docsWrap.create('label','result','Отклонено');
							docsWrap.attr('for','img' + i + i);
							docsWrap.create('input','result','1');
							docsWrap.attr('id','img' + i + i);
							docsWrap.attr('type','radio');
							docsWrap.attr('name','result[' + arg.docs.doc[i].id + ']');
							docsWrap.attr('value','0');

							docsWrap.create('label','result','Принято');
							docsWrap.attr('for','img' + i);
							docsWrap.create('input','result','1');
							docsWrap.attr('id','img' + i);
							docsWrap.attr('type','radio');
							docsWrap.attr('name','result[' + arg.docs.doc[i].id + ']');
							docsWrap.attr('value','1');

							docsWrap.create('br');
							docsWrap.create('label','result','Комментарий');
							docsWrap.attr('for','comment' + i);
							docsWrap.create('textarea','result');
							docsWrap.attr('id','comment' + i);
							docsWrap.attr('name','comment[' + arg.docs.doc[i].id + ']');
						} else {
							if(count < 1) {
								history.create('div','thead');
								var tHead = new BuildElements(history.lastEl);
								tHead.create('div','tr');
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
							var tr = new BuildElements(tBody.lastEl);
							tr.create('div','td',arg.docs.doc[i].doc_name);
							tr.create('div','td',arg.docs.doc[i].dt_insert);
							tr.create('div','td',arg.docs.doc[i].dt_check);
							tr.create('div','td',arg.docs.doc[i].login_check);
							tr.create('div','td',arg.docs.doc[i].result_check);
							tr.create('div','td',arg.docs.doc[i].comment_check);
							tr.create('div','td');
							var tdImg = new BuildElements(tr.lastEl);
							tdImg.create('div','image');
							var docsWrap = new BuildElements(tdImg.lastEl);
							docsWrap.create('div','image_wrap');
							var docsImg = new BuildElements(docsWrap.lastEl);
							docsImg.create('img');
							docsImg.attr('src',arg.docs.doc[i].doc_file);
							docsWrap.create('div','tools');
							count++;
						}
					}

					docs.create('input');
					docs.attr('type','hidden');
					docs.attr('name','docs');
					docs.attr('value',arg.descr.id);
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



function addVideo(parent) {
	var video = new BuildElements(parent);
	video.create('div','files');
	var files = new BuildElements(video.lastEl);
	files.create('label');
	files.attr('for','video');
	var videoFile = new BuildElements(files.lastEl);
	videoFile.create('img');
	videoFile.attr('src','/app/template/img/play.svg');
	videoFile.create('input');
	videoFile.attr('id','video');
	videoFile.attr('type','file');
	videoFile.attr('name','video');
	videoFile.create('span','info','Загрузите видео в формате MP4');
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
	$$('.more').forEach(function(el, i) {
		el.addEventListener('click', function(e) {
			e.preventDefault();
			$('#popup form').setAttribute('data-href','/events/edit?action=update&full=true');
			popup.open('#popup');
			request(e.target.href,function(arg) {
				var parentEl = $('#popup');
				
				var data = new BuildElements($('.block_data'));
				for(i in arg.descr) {
					if(i !== 'video') {
						data.create('label',null,arg.title[i]);
						data.attr('for',i);
					}
					switch(i) {
						case 'descr' :
						data.create('textarea',null,arg.descr[i]);
						data.attr('id',i);
						data.attr('name',i);
						break;
						case 'modality':
						case 'ssapm':
						data.create('select');
						data.attr('id',i);
						data.attr('name',i);
						childData = new BuildElements(data.lastEl);
						for(j in arg[i]) {
							childData.create('option',null,arg[i][j].name);
							childData.attr('value',arg[i][j].id);
							if(arg[i][j].id === arg.descr[i]) {
								childData.attr('selected',true);
							}
						}

						break;
						case 'public':
						data.create('input');
						data.attr('id',i);
						data.attr('name',i);
						data.attr('type','checkbox');
						if(arg.descr[i] == 1) {
							data.attr('checked',true);
						}
						break;
						case 'video':
						if(!isEmpty(arg.descr[i])) {
							var video = new BuildElements($('.block_video'));
							video.create('video');
							video.attr('src',arg.descr[i]);
							video.attr('controls', true);
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
							data.attr('type','number');
							data.attr('min',0);
							break;
							case 'id':
							data.attr('readonly', true);
						}
						data.attr('id',i);
						data.attr('name',i);
						data.attr('value',!isEmpty(arg.descr[i]) ? arg.descr[i] : '');
						break;
					}
				}
				if(!isEmpty(arg.docs)) {
					var docs = new BuildElements($('.block_docs'));
					for(i in arg.docs) {
						docs.create('div','image');
						var docsWrap = new BuildElements(docs.lastEl);
						docsWrap.create('div','image_wrap');
						var docsImg = new BuildElements(docsWrap.lastEl);
						docsImg.create('img');
						docsImg.attr('src',arg.docs[i].doc_file);
						docsWrap.create('div','tools');
					}
				}
				filesChange();
			});

		});
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
			var data = new BuildElements($('.block_data'));
			for(i in arg.title) {
				if(i !== 'id') {
					data.create('label',null,arg.title[i]);
					data.attr('for',i);
				}
				switch(i) {
					case 'id':
					break;
					case 'modality':
					case 'ssapm':
					data.create('select');
					data.attr('id',i);
					data.attr('name',i);
					childData = new BuildElements(data.lastEl);
					for(j in arg[i]) {
						childData.create('option',null,arg[i][j].name);
						childData.attr('value',arg[i][j].id);
					}

					break;
					case 'public':
					data.create('input');
					data.attr('id',i);
					data.attr('name',i);
					data.attr('type','checkbox');
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
						data.attr('type','number');
						data.attr('min',0);
						break;
						case 'id':
						data.attr('readonly', true);
					}
					data.attr('id',i);
					data.attr('name',i);
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

			var el = new BuildElements($('.image.active .tools'));
			el.create('i','close');
			el.create('i','full');
			el.create('i','zoom');
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
			var elZoom = new BuildElements($('.image.active .image_wrap'));

			elZoom.create('div','zoom_img');
			var zoomImg = new BuildElements(elZoom.lastEl);
			zoomImg.create('img');
			zoomImg.attr('src', $('.image.active .image_wrap img').src);
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
				var tr = new BuildElements(parentEl.parentElement.previousElementSibling);
				tr.create('div','tr');
				var td = new BuildElements(tr.lastEl);
				td.create('div','td');
				var inp = new BuildElements(td.lastEl);
				inp.create('input');
				inp.attr('type','text');
				inp.attr('value',parentEl.querySelector('input').value);
				inp.attr('name',parentEl.querySelector('input').getAttribute('data-name') + '[new][]');
				var td = new BuildElements(tr.lastEl);
				td.create('div','td');
				var btn = new BuildElements(td.lastEl);
				btn.create('i','button edit del','-');
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
		var images = new BuildElements($('.files'));
		var count = 0;
		function addFormDoc() {
			images.create('div','doc');
			var doc = new BuildElements(images.lastEl);
			doc.create('label','document');
			doc.attr('for','img' + count);
			var childImages = new BuildElements(doc.lastEl);
			childImages.create('img');
			childImages.attr('src','/app/template/img/photo.svg');
			childImages.create('input','image');
			childImages.attr('id','img' + count);
			childImages.attr('type','file');
			if($('.files').childElementCount <= 1) {
				childImages.attr('required',true);
			}
			doc.create('div','comment');
			var childImages = new BuildElements(doc.lastEl);
			childImages.create('label','h3','Наименование документа');
			childImages.attr('for','comment' + count);
			childImages.create('textarea','docs_name');
			childImages.attr('id','comment' + count);

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
					var error = new BuildElements(e.target.parentElement);
					error.create('span','info');
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