/**
 * 非同期通信クラス
 */
export class ApiURL {

  // 共通部分
  static CONTROLLER = '/graph/controller';
  /** ログイン */
  static LOGIN = ApiURL.CONTROLLER + '/LoginControler.php';
  /** ログアウト */
  static LOGOUT = ApiURL.CONTROLLER + '/LogoutControler.php';
  
  /** ユーザ */
  static SIGNUP = ApiURL.CONTROLLER + '/CreateAccountControler.php';
  static DELETE_ACCOUNT = ApiURL.CONTROLLER + '/DeleteAccountControler.php';

  /** 作品 */
  static SEARCH_ALL_OPUS = ApiURL.CONTROLLER + '/SearchAllOpusControler.php';
  static SEARCH_OPUS = ApiURL.CONTROLLER + '/SearchOpusControler.php';
  static CREATE_OPUS = ApiURL.CONTROLLER + '/CreateOpusControler.php';
  static EDIT_OPUS = ApiURL.CONTROLLER + '/EditOpusControler.php';
  static DELETE_OPUS = ApiURL.CONTROLLER + '/DeleteOpusControler.php';

  /** 時系列 */
  static SEARCH_TIME = ApiURL.CONTROLLER + '/SearchTimeControler.php';
  static CREATE_TIME = ApiURL.CONTROLLER + '/CreateTimeControler.php';
  static EDIT_TIME = ApiURL.CONTROLLER + '/EditTimeControler.php';
  static DELETE_TIME = ApiURL.CONTROLLER + '/DeleteTimeControler.php';

  /** グループ */
  static SEARCH_GROUP = ApiURL.CONTROLLER + '/SearchGroupControler.php';
  static CREATE_GROUP = ApiURL.CONTROLLER + '/CreateGroupControler.php';
  static EDIT_GROUP = ApiURL.CONTROLLER + '/EditGroupControler.php';
  static DELETE_GROUP = ApiURL.CONTROLLER + '/DeleteGroupControler.php';

  /** グラフ */
  static SEARCH_GRAPH = ApiURL.CONTROLLER + '/SearchGraphControler.php';
  static CREATE_GRAPH = ApiURL.CONTROLLER + '/CreateGraphControler.php';

  /** グラフ */
  static COMMON_MST = ApiURL.CONTROLLER + '/SearchCommonControler.php';

  /** ユーザ管理機能 */
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
