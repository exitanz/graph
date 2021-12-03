from ..common.Constant import Constant


# /**
# * 時系列削除処理の値を保持する
# */
class DeleteTimeRequest:
    errorMsg = []

    # /**
    # * 時系列削除処理の値を格納します
    # */
    def __init__(self, timeId, userId):
        self.timeId = timeId
        self.userId = userId

    def getTimeId(self):
        return self.timeId

    def getUserId(self):
        return self.userId

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.timeId) == 0 or len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 時系列IDの文字数チェック
            if (Constant.TIME_ID_DIGIT + len(Constant.TIME_ID_STR) < len(self.timeId)):
                self.errorMsg.append(
                    'エラー ：時系列IDは' + Constant.TIME_ID_DIGIT + len(Constant.TIME_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
