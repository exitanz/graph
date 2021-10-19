/**
 * 定数クラス
 */
export class Constant {
    // 作品一覧表示数
    static OPUS_LIST_MAX = 20;
    // ユーザID 先頭文字列
    static USER_ID_STR = "user";
    // ユーザID 桁数
    static USER_ID_DIGIT = 6;
    // ユーザID 結合桁数
    static USER_ID_LENGTH = Constant.USER_ID_STR.length + Constant.USER_ID_DIGIT;
    // 登場人物ID 先頭文字列
    static ACTOR_ID_STR = "actor";
    // 登場人物ID 桁数
    static ACTOR_ID_DIGIT = 3;
    // 登場人物ID 結合桁数
    static ACTOR_ID_LENGTH = Constant.ACTOR_ID_STR.length + Constant.ACTOR_ID_DIGIT;
    // 時系列ID 先頭文字列
    static TIME_ID_STR = "time";
    // 時系列ID 桁数
    static TIME_ID_DIGIT = 4;
    // 時系列ID 結合桁数
    static TIME_ID_LENGTH = Constant.TIME_ID_STR.length + Constant.TIME_ID_DIGIT;
    // 関係ID 先頭文字列
    static REL_ID_STR = "rel";
    // 関係ID 桁数
    static REL_ID_DIGIT = 6;
    // 関係ID 結合桁数
    static REL_ID_LENGTH = Constant.REL_ID_STR.length + Constant.REL_ID_DIGIT;
    // 関係性マスタID 先頭文字列
    static REL_MST_ID_STR = "relmst";
    // 関係性マスタID 桁数
    static REL_MST_ID_DIGIT = 4;
    // 関係性マスタID 結合桁数
    static REL_MST_ID_LENGTH = Constant.REL_MST_ID_STR.length + Constant.REL_MST_ID_DIGIT;
    // グループマスタID 先頭文字列
    static GROUP_ID_STR = "group";
    // グループマスタID 桁数
    static GROUP_ID_DIGIT = 4;
    // グループマスタID 結合桁数
    static GROUP_ID_LENGTH = Constant.GROUP_ID_STR.length + Constant.GROUP_ID_DIGIT;
    // 作品ID 先頭文字列
    static OPUS_ID_STR = "opus";
    // 作品ID 桁数
    static OPUS_ID_DIGIT = 4;
    // 作品ID 結合桁数
    static OPUS_ID_LENGTH = Constant.OPUS_ID_STR.length + Constant.OPUS_ID_DIGIT;
}
