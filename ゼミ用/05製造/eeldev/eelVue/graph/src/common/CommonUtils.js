import Cookies from 'js-cookie';

export class CommonUtils {
  /**
   * 画面遷移用URL作成します
   * @param name 遷移先画面名
   * @returns 画面URL
   */
  static createUrl(name) {
    return './templates/' + name + '.html';
  }

  /**
   * APIURL作成します
   * @param name API名
   * @param replaceName 置換対象文字
   * @param paramId 置換する文字
   * @returns APIURL
   */
  static createApiUrlPathParam(name, replaceName, paramId) {
    return name.replace(replaceName, paramId);
  }

  /**
   * APIheader作成します
   * @returns APIheader
   */
  static createApiHeader() {
    // console.log(cookie);
    let header = {
      withCredentials: true,
      headers: {
        'Content-Type': 'application/json',
      },
    };

    return header;
  }

  /**
   * Cookieの登録を行います
   * @param name クッキー名
   * @param value クッキー値
   */
  static setCookie(name, value) {
    Cookies.set(name, value, { expires: 1 });
  }

  /**
   * Cookieの取得を行います
   * @param name クッキー名
   * @returns クッキー値
   */
  static getCookie(name) {
    return Cookies.get(name);
  }

  /**
   * Cookieの削除を行います
   * @param name クッキー名
   */
  static delCookie(name) {
    Cookies.remove(name);
  }

  /**
   * 比較対象1と比較対象2の比較結果を返却します
   * @param obj1 比較対象1
   * @param obj2 比較対象2
   * @returns 比較結果
   */
  static eq(obj1, obj2) {
    if (typeof obj1 === 'undefined') {
      return false;
    }
    if (typeof obj2 === 'undefined') {
      return false;
    }
    return obj1 == obj2;
  }
}
