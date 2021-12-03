from ..common.Constant import Constant


# /**
# * 作品登録処理の値を保持する
# */
class CreateOpusRequest:
    errorMsg = []

    # /**
    # * 作品登録処理の値を格納します
    # */
    def __init__(self, opusId, opusName, userId):
        self.opusId = opusId
        self.opusName = opusName
        self.userId = userId

    def getOpusId(self):
        return self.opusId

    def getOpusName(self):
        return self.opusName

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
            if (len(self.opusName) == 0 or len(self.opusId) == 0 or len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 作品名の文字数チェック
            if (100 < len(self.opusName)):
                self.errorMsg.append('エラー ：作品名は100文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
