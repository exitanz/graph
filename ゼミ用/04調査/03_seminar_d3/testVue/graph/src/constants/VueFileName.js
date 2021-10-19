/**
 * 非同期通信クラス
 */
export class VueFileName {
  /** ホーム [/] */
  static footer = 'footer';
  static loginMenu = 'loginMenu';
  static listMenu = 'listMenu';
  static createMenu = 'createMenu';
  static submitMenu = 'submitMenu';

  /** ログイン [login] */
  static login = 'login';

  /** ユーザ管理機能
   * [/signup , /search , /account]
   */
  static userCreate = 'userCreate';

  /** パスワード管理機能 */
  static question = 'question';

  /** 相関図機能 */
  static graphCreate = 'graphCreate';
  static graphList = 'graphList';
  static graphSubmit = 'graphSubmit';

  /** エラーページ */
  static NotFound = 'NotFound';
}
