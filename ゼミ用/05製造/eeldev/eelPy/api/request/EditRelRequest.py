from ..common.Constant import Constant


# /**
# * 関係編集処理の値を保持する
# */
class EditRelRequest:
    errorMsg = []

    # /**
    # * 関係編集処理の値を保持する
    # */
    def __init__(self, relId, relMstId, relMstInfo, actorId, targetId, opusId, timeId, userId, version):
        self.relId = relId
        self.relMstId = relMstId
        self.relMstInfo = relMstInfo
        self.actorId = actorId
        self.targetId = targetId
        self.opusId = opusId
        self.timeId = timeId
        self.userId = userId
        self.version = version

    def getRelId(self):
        return self.relId

    def getRelMstId(self):
        return self.relMstId

    def getRelMstInfo(self):
        return self.relMstInfo

    def getActorId(self):
        return self.actorId

    def getTargetId(self):
        return self.targetId

    def getOpusId(self):
        return self.opusId

    def getTimeId(self):
        return self.timeId

    def getUserId(self):
        return self.userId

    def getVersion(self):
        return self.version

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.relId) == 0 or len(self.opusId) == 0 or len(self.timeId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係IDの文字数チェック
            if (Constant.REL_ID_DIGIT + len(Constant.REL_ID_STR) < len(self.relId)):
                self.errorMsg.append(
                    'エラー ：関係IDは' + Constant.REL_ID_DIGIT + len(Constant.REL_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # 関係性IDの文字数チェック
            if (Constant.REL_MST_ID_DIGIT + len(Constant.REL_MST_ID_STR) < len(self.relMstId)):
                self.errorMsg.append(
                    'エラー ：関係性IDは' + Constant.REL_MST_ID_DIGIT + len(Constant.REL_MST_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # 関係詳細の文字数チェック
            if (1200 < len(self.relMstInfo)):
                self.errorMsg.append('エラー ：関係詳細は1200文字以内で入力してください')
                validationFlg = True

            # 登場人物IDの文字数チェック
            if (Constant.ACTOR_ID_DIGIT + len(Constant.ACTOR_ID_STR) < len(self.actorId)):
                self.errorMsg.append(
                    'エラー ：登場人物IDは' + Constant.ACTOR_ID_DIGIT + len(Constant.ACTOR_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # 作品IDの文字数チェック
            if (Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.opusId)):
                self.errorMsg.append(
                    'エラー ：作品IDは' + Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
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
