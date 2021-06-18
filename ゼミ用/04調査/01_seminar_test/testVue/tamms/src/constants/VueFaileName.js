/**
 * 非同期通信クラス
 */
export class VueFaileName {
  /** ホーム [/] */
  static footer = 'footer';
  static menu = 'menu';
  static menu2 = 'menu2';

  /** ログイン [login] */
  static login = 'login';
  /** ログアウト [/logout] */
  static logout = 'logout';

  /** ユーザ管理機能
   * [/signup , /search , /account]
   */
  static userCreate = 'userCreate';
  static userDelete = 'userDelete';
  static userEdit = 'userEdit';
  static userManage = 'userManage';

  /** パスワード管理機能 */
  static question = 'question';

  /** カレンダー機能 */
  static calendar = 'calendar';

  /** 収入管理機能 */
  static incomeCreate = 'incomeCreate';
  static incomeEdit = 'incomeEdit';
  static incomeHistory = 'incomeHistory';

  /** 収入カテゴリ管理機能 [/income/category] */
  static incCategoryCreate = 'incCategoryCreate';
  static incCategoryEdit = 'incCategoryEdit';
  static incCategoryMenu = 'incCategoryMenu';

  /** 支出管理機能 */
  static paymentCreate = 'paymentCreate';
  static paymentEdit = 'paymentEdit';
  static paymentHistory = 'paymentHistory';

  /** 支出カテゴリ管理機能・カテゴリ別予算管理機能 */
  static budget = 'budget';
  static payCategoryCreate = 'payCategoryCreate';
  static payCategoryEdit = 'payCategoryEdit';
  static payCategoryMenu = 'payCategoryMenu';

  /** 振替管理機能 */
  static transCreate = 'transCreate';
  static transEdit = 'transEdit';
  static transHistory = 'transHistory';

  /** 口座管理機能 */
  static walletCreate = 'walletCreate';
  static walletData = 'walletData';
  static walletEdit = 'walletEdit';
  static walletManage = 'walletManage';

  /** 食事管理機能 */
  //   static EAT = 'eat';

  /** スケジュール管理機能 */
  //   static SCHEDULE = 'schedule';

  /** エラーページ */
  static NotFound = 'NotFound';
}
