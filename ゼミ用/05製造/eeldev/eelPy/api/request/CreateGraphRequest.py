from ..common.Constant import Constant


# /**
# * グラフ登録処理の値を保持する
# */
class CreateGraphRequest:
    errorMsg = []

    # /**
    # * グラフ登録処理の値を格納します
    # */
    def __init__(self, opusId, userId):
        self.opusId = opusId
        self.userId = userId

    def getOpusId(self):
        return self.opusId

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
            if (len(self.opusId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 作品IDの文字数チェック
            if (Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.opusId)):
                self.errorMsg.append(
                    'エラー ：作品IDは' + Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
