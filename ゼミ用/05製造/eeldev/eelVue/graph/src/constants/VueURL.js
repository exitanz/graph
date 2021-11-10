/**
 * 非同期通信クラス
 */
export class VueURL {
  /** ホーム [/] */
  static HOME = '/';

  /** ログイン [/login] */
  static LOGIN = '/login';
  /** ログアウト [/logout] */
  static LOGOUT = '/logout';

  /** ユーザ管理機能
   * [/signup , /search , /account]
   */
  static SIGNUP = '/signup';
  static SEARCH = '/search';
  static ACCOUNT = '/account';

  /** パスワード管理機能 */
  static QUESTION = '/question';

  /** カレンダー機能 */
  static CALENDER = '/calendar';

  /** 収入管理機能 */
  static INCOME = '/income';

  /** 収入カテゴリ管理機能 [/income/category] */
  static INCOME_CATEGORY = '/income/category';

  /** 支出管理機能 */
  static PAYMENT = '/payment';

  /** 支出カテゴリ管理機能・カテゴリ別予算管理機能 */
  static PAYMENT_CATEGORY = '/payment/category';

  /** 振替管理機能 */
  static TRANSFER = '/transfer';

  /** 口座管理機能 */
  static WALLET = '/wallet';

  /** 食事管理機能 */
  static EAT = '/eat';

  /** スケジュール管理機能 */
  static SCHEDULE = '/schedule';

  /** エラー */
  static ERORR = '/error';
}
