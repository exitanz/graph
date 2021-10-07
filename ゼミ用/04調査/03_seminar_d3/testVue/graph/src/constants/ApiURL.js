/**
 * 非同期通信クラス
 */
export class ApiURL {

  // 共通部分
  static CONTROLLER = '/graph/controller';
  /** ログイン */
  static LOGIN = ApiURL.CONTROLLER + '/LoginControler.php';
  /** ログアウト */
  static LOGOUT = '/user/logout';

  /** 作品 */
  static SEARCH_OPUS = ApiURL.CONTROLLER + '/SearchOpusControler.php';
  static DELETE_ACCOUNT = ApiURL.CONTROLLER + '/DeleteAccountControler.php';

  /** ユーザ管理機能 */
  static SIGNUP = '/signup';
  static SEARCH = '/user/search';
  static ACCOUNT = '/account';

  /** パスワード管理機能 */
  static QUESTION = '/question';

  /** カレンダー機能 */
  static CALENDER = '/calendar';

  /** 収入管理機能 */
  static INCOME = '/income';
  static INC_ID = '/income/{incId}';
  static INC_ID_NAME = '{incId}';

  /** 収入カテゴリ管理機能 */
  static INCOME_CATEGORY = '/income/category';
  static INC_CATEGORY_ID = '/income/category/{incCategoryId}';
  static INC_CATEGORY_ID_NAME = '{incCategoryId}';

  /** 支出管理機能 */
  static PAYMENT = '/payment';
  static PAY_ID = '/payment/{payId}';
  static PAY_ID_NAME = '{payId}';

  /** 支出カテゴリ管理機能 */
  static PAYMENT_CATEGORY = '/payment/category';
  static PAY_CATEGORY_ID = '/payment/category/{payCategoryId}';
  static PAY_CATEGORY_ID_NAME = '{payCategoryId}';

  /** カテゴリ別予算管理機能 */
  static BUDGET = '/payment/budget';

  /** 振替管理機能 */
  static TRANSFER = '/transfer';
  static TRA_ID = '/transfer/{traId}';
  static TRA_ID_NAME = '{traId}';

  /** 口座管理機能 */
  static WALLET = '/wallet';
  static BANK_ID = '/wallet/{bankId}';
  static BANK_ID_NAME = '{bankId}';

  /** 食事管理機能 */
  static EAT = '/eat';
  static EAT_ID = '/eat/{eatId}';

  /** スケジュール管理機能 */
  static SCHEDULE = '/schedule';
  static SCHEDULE_ID = '/schedule/{scheduleId}';
}
