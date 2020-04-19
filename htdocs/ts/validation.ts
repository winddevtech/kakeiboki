"use strict";

class User{


    '使用できる画像はjpg、jpeg、png、gif形式のみです。';
}

function userAction() {
    var wk_user_obj = new User();

    var icon = document.getElementById('js-upload_btn').value;
    var post_icon = document.getElementById('js-post_icon_img').value;



    if (icon != ''){
        post_icon = post_icon.split('/');
        post_icon = post_icon[1].split(';');
        wk_user_obj.setIcon(post_icon[0]);
        wk_user_obj.chkIcon();
    }

    return wk_user_obj.getChkRsult();
}


class Validation {
  private errMsg: string;
    constructor (){
        this.errMsg = '';
    }

    static valInput(str):boolean{
        if (str == '') {
            return false;
        }
        return true;
    }

    static strLen (str, max_len):boolean{
        if (str.length > max_len) {
            return false;
        }
        return true;
    }

    static emailFormat (str):boolean {
        var email_format = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!str.match(email_format)) {
            return false;
        }
        return true;
    }

    static strRound (str:string, minSize:number, maxSize:number):boolean {
        if (str.length < minSize || maxSize < str.length) {
            return false;
        }
        return true;
    }

    static date(date):boolean {
        var date_format = /([1-9][0-9]{3})\/(0[1-9]{1}|1[0-2]{1})\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})/;
        if (!date.match(date_format)) {
            return false;
        }
        return true;
    }

    static price(price_len):boolean {
        var max_len_price = 8 //1千万円の桁数;
        if (price_len > max_len_price) {
            return false;
        }
        return true;
    }

    static fileFormat(str):boolean {
        var file_format = ".+\.csv";
        if (!str.match(file_format)) {
            return false;
        }
        return true;
    }

    static pictureFormat(str):boolean {
        var white_list = Array('jpg', 'jpeg', 'png', 'gif');
        if (white_list.indexOf(str) == -1){
            return false;
        }
        return true;
    }

    static strCompare(str1, str2):boolean{
        if (str1!= str2) {
            return false;
        }
        return true;
    }
}


class EventType {
    static CLICK: string = 'click';
    static LOAD: string = 'load';
}

class ValidationController {
  static validation(value:string, validate:any):string{
    var length = Object.keys(validate).length;
    var isErrFlg = null;
    var errMsg = '';
    for (var i = 0; i < length; i++) {
      var type = Object.keys(validate)[i];
      switch(type){
        case 'require':
          errMsg = validate[type];
          isErrFlg = Validation.valInput(value);
          break;
        case 'format':
          errMsg = validate[type];
          isErrFlg = Validation.emailFormat(value)
          break;
        case 'size':
          errMsg = validate[type][1];
          isErrFlg = Validation.strLen(value, validate[type][0]);
          break;
        case 'between':
          errMsg = validate[type][2];
          isErrFlg = Validation.strRound(value, validate[type][0], validate[type][1]);
          break;
        default:
          break;
      }

      if (! isErrFlg){
        break;
      }
    }

    if (! isErrFlg){
      return errMsg;
    }
    return '';
  }

  static counter(value:string, maxSize:number):number{
    return value.length - maxSize;
  }
}

class BaseForm {
  private domForm:any;
  constructor(domForm){
    this.domForm = domForm;
  }

  protected getDomForm(): any{
    return this.domForm;
  }
}

class UserForm extends BaseForm {
    constructor(domForm){
      super(domForm);
    }

    public realtime(){
      var setErrMsg = function (idName:string, errMsg:string){
        document.querySelector(idName).innerHTML = errMsg;
      };
      document.querySelector('#username').addEventListener('blur', function() {
        setErrMsg ('#js-valid_username', ValidationController.validation(
          this.value, {
            'require':'ユーザー名を入力して下さい。',
            'size': [20,'ユーザー名は20文字以内で入力して下さい。']
          })
        );
      }, false);
      document.querySelector('#email').addEventListener('blur', function() {
        setErrMsg ('#js-valid_email', ValidationController.validation(
          this.value, {
            'require':'Emailを入力して下さい。',
            'format':'Emailの形式が不正です。',
            'size':[50, 'Emailは50文字以内で入力して下さい。']
          })
        );
      }, false);
      document.querySelector('#password').addEventListener('blur', function() {
        setErrMsg ('#js-valid_password', ValidationController.validation(
          this.value, {
            'require':'パスワードを入力して下さい。',
            'between':[8, 30, 'パスワードの長さは8文字以上、30文字以内で入力して下さい。']
          })
        );
      }, false);
      document.querySelector('#password_conf').addEventListener('blur', function() {
        var errMsg = ValidationController.validation(
          this.value, {
            'require':'確認用パスワードを入力して下さい。',
            'between':[8, 30, '確認用パスワードの長さは8文字以上、30文字以内で入力して下さい。']}
        );
        if (errMsg == '' && document.querySelector('#password').value != this.value) {
          errMsg = 'パスワードと確認用パスワードが一致しません。';
        }
        setErrMsg ('#js-valid_password', errMsg);
      }, false);

    }
}

class ContactForm {
  private maxLenContext:number;
    constructor(form){
      this.maxLenContext = 1000;
    }

    public realtime(){
      var setErrMsg = function (idName:string, errMsg:string){
        document.querySelector(idName).innerHTML = errMsg;
      };
      document.querySelector('#categoly').addEventListener('change', function() {
        setErrMsg ('#js-valid_categoly', ValidationController.validation(
          this.value, {
            'require':'カテゴリを選択して下さい。'
          })
        );
      }, false);

      document.querySelector('#context').addEventListener('keyup', function() {
        setErrMsg ('#js-counter_context', (1000 - this.value.length).toString());
      }, false);
    }
}

class AuthForm extends BaseForm {
  constructor(domForm){
    super(domForm);
  }

  public realtime(){
    var setErrMsg = function (idName:string, errMsg:string){
      document.querySelector(idName).innerHTML = errMsg;
    };
    document.querySelector('#email').addEventListener('blur', function() {
      setErrMsg('#js-valid_email', ValidationController.validation(
        this.value, {
          'require':'Emailを入力して下さい。',
          'format':'Emailの形式が不正です。'
        })
      );
    }, false);
  }
}

class LoginForm extends BaseForm {

  constructor(domForm){
    super(domForm);
  }

  public realtime(){
    var setErrMsg = function (idName:string, errMsg:string){
      document.querySelector(idName).innerHTML = errMsg;
    };

    document.querySelector('#email').addEventListener('blur', function() {
      setErrMsg('#js-valid_email', ValidationController.validation(
        this.value, {
          'require':'Emailを入力して下さい。',
          'format':'Emailの形式が不正です。'
        })
      );
    }, false);

    document.querySelector('#password').addEventListener('blur', function() {
      setErrMsg('#js-valid_password', ValidationController.validation(
        this.value, {
          'require':'パスワードを入力して下さい。'
        })
      );
    }, false);
  }
}

class FormDispatcher {
  static getForm (dirName, form){
    var map = null;
    switch (dirName) {
      case 'signup':
      case 'edit':
        map = new UserForm(form);
        break;
      case 'contact':
        map = new ContactForm(form);
        break;
      case 'auth':
        map = new AuthForm(form);
        break;
      default:
        map = new LoginForm(form);
        break;
    }
    return map;
  }
}

window.addEventListener(EventType.LOAD, function(){
  var urlArray = window.location.href.split('/').slice(-2);
  var formObj = FormDispatcher.getForm(urlArray[0], document.querySelector('#js-form'));
  formObj.realtime();
}, false);

document.querySelector('#js-submitBtn').addEventListener(EventType.CLICK, function(){
  var urlArray = window.location.href.split('/').slice(-2);
}, false);
