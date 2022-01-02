import React, { Component } from 'react'
import { StyleSheet, Text, View, Image, Pressable,Modal,Share,Alert,ActivityIndicator,BackHandler } from 'react-native'
import { withTheme, Button,Snackbar } from 'react-native-paper';
import { LinearGradient } from 'expo-linear-gradient';
import ImageViewer from 'react-native-image-zoom-viewer';
import * as MediaLibrary from 'expo-media-library';
import * as FileSystem from 'expo-file-system';
import MCIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import { ERContext } from '../ERContext';
import AwesomeAlert from 'react-native-awesome-alerts';
import axios from 'axios';
import ActivityLoading from './ActivityLoading';
import { HOST, LoaderPng } from './config';
import ResumePlaceholder from './../assets/resumePlaceholder.png'
import qs from 'qs'

class Preview extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
             showLoading:true,
             preview:false,
             showSnackbar:false,
             snackbarText:'',
             resumeLink:null,
             resumeImage:null,
             images:[],
             oldResume:false,

             showAlert: false,
             showModalProgress:false,
             modalTitle:'',
             modalMessage:'',
             closeOnTouchOutside:false,
             showConfirmButton:false,
             confirmText:'',
             onConfirmPressed:()=>this.hideAlert(),
        }
    }
    componentDidMount (){

        this.loadResumeData();
    }

    loadResumeData = ()=>{
        if(this.props.route.params.resume){
            //alert('already generated');

            let tempImages = [...this.state.images,{url:this.props.route.params.resume.r_thumbnail}];
            this.setState({
                showLoading:false,
                resumeLink: this.props.route.params.resume.r_location,
                resumeImage: this.props.route.params.resume.r_thumbnail,
                images:tempImages
            })
        }else{
            this.generatePdf();
        }
    }

    hideAlert = () =>{
        this.setState({showAlert:false});
    }

    generatePdf = async()=>{
        //console.log(this.props.route.params.templateData);
        if(this.context.isConnected){
            try{

                const response = await axios.post(HOST+'/generate',this.props.route.params.templateData,{
                    headers:{
                        "Authorization":this.context.token,
                    }
                });
               // console.log(response);
                if(response.status === 200){
                    if(response.data.success === true){

                        //pdf generated successfully
                        let tempImages = [...this.state.images,{url:response.data.thumbnail}];
                        this.setState({
                            resumeLink:response.data.data,
                            resumeImage:response.data.thumbnail,
                            images:tempImages
                        })
                       // console.log(response.data.data);
                    }else{
                        //failed to generate pdf
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Failed to generate",
                            modalMessage: '',
                            closeOnTouchOutside: true,
                        });
                        this.props.navigation.goBack();
                    }

                }else{
                    //request status is not  200
                    this.setState({
                        showAlert: true,
                        showModalProgress:false,
                        modalTitle:"Server error",
                        modalMessage: "Something went wrong in the server",
                        closeOnTouchOutside: true,
                    });
                }
            }catch(error){
                //console.log(error);
                alert('Something went wrong');
            }
        }else{
            //if network is not connected
            this.setState({
                showAlert: true,
                showModalProgress:false,
                modalTitle:"Ooops !",
                modalMessage:"No Internet Connection found\n Check your connection",
                closeOnTouchOutside: true,
            });
        }
        this.setState({showLoading:false})
    }

    onDelete = async()=>{
        this.setState({
            showAlert: true,
            showModalProgress:true,
            modalTitle:"",
            modalMessage:"Deleting",
            closeOnTouchOutside: false,
        });
        if(this.context.isConnected){
            try{
                const params={
                    resumeNo: this.props.route.params.resume.resumeNo,
                }

                const response = await axios.post(HOST+'/delete',qs.stringify(params),{
                    headers:{
                        "Authorization":this.context.token,
                    }
                });
               // console.log(response);
                if(response.status === 200){
                    if(response.data.success === true){

                        //deleted successfully
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Success",
                            modalMessage: 'Resume deleted successfully',
                            closeOnTouchOutside: true,
                        });
                        this.props.navigation.goBack();
                       // console.log(response.data.data);
                    }else{
                        //failed to delete
                        this.setState({
                            showAlert: true,
                            showModalProgress:false,
                            modalTitle:"Failed",
                            modalMessage: 'Failed to delete resume',
                            closeOnTouchOutside: true,
                        });
                    }

                }else{
                    //request status is not  200
                    this.setState({
                        showAlert: true,
                        showModalProgress:false,
                        modalTitle:"Server error",
                        modalMessage: "Something went wrong in the server",
                        closeOnTouchOutside: true,
                    });
                }
            }catch(error){
                //console.log(error);
                alert('Something went wrong');
            }
        }else{
            //if network is not connected
            this.setState({
                showAlert: true,
                showModalProgress:false,
                modalTitle:"Ooops !",
                modalMessage:"No Internet Connection found\n Check your connection",
                closeOnTouchOutside: true,
            });
        }
        this.hideAlert();
    }
    onShare = async () => {
        try {
          const result = await Share.share({
            message: 'Hey, I create a resume using Easy Resume Maker, check it here '+this.state.resumeLink,
          });
          if (result.action === Share.sharedAction) {
            if (result.activityType) {
              // shared with activity type of result.activityType
            } else {
              // shared
            }
          } else if (result.action === Share.dismissedAction) {
            // dismissed
          }
        } catch (error) {
          Alert.alert(error.message);
        }
    }


    downloadFile(){
        this.setState({
            showSnackbar:true,
            snackbarText: 'Download has started'
        });

        const uri = this.state.resumeLink;
        let fileUri = FileSystem.documentDirectory + this.context.name+"_EasyResume.pdf";
        //console.log(fileUri);
        FileSystem.downloadAsync(uri, fileUri)
        .then(({ uri }) => {
            this.saveFile(uri);
          })
          .catch(error => {
            //console.error(error);
            alert('Something went wrong');
          })
    }

    saveFile = async (fileUri) => {
        try{
            MediaLibrary.requestPermissionsAsync();
            const asset = await MediaLibrary.createAssetAsync(fileUri);
            let data = await MediaLibrary.createAlbumAsync("EasyResume", asset, false);

            this.setState({
                showSnackbar:true,
                snackbarText: 'Download completed. Saved in Picture/EasyResume'
            });
        }catch(e){
            try{
                MediaLibrary.requestPermissionsAsync();
                const asset = await MediaLibrary.createAssetAsync(fileUri);
                let data = await MediaLibrary.createAlbumAsync("EasyResume", asset, false);
    
                this.setState({
                    showSnackbar:true,
                    snackbarText: 'Download completed. Saved in Picture/EasyResume'
                });
            }catch(e){
                this.setState({
                    showSnackbar:true,
                    snackbarText: 'File Permission Denied'
                });
            }
        }
    }
    render() {
        const {showAlert,
            showModalProgress,
            modalTitle,
            modalMessage,
            closeOnTouchOutside,showConfirmButton,
            confirmText,
            onConfirmPressed} = this.state;
        const {colors} = this.props.theme;

        console.log(this.props.route.params.templateData);
        const {showSnackbar, snackbarText} = this.state;
        if(this.state.showLoading)
            return <ActivityLoading msg ="Generating Resume"/>
        else
        return (
            <>
            <View style={styles.container}>
                <View style={styles.imageContainer}>
                    <Pressable
                        onPress={()=>{this.setState({preview:true})}}
                    >
                        {
                            this.state.resumeImage?
                                <Image style={styles.resumeImage} resizeMode="contain" source={{uri:this.state.resumeImage}} loadingIndicatorSource={{uri:LoaderPng}}/>
                            :
                                <Image style={styles.resumeImage} resizeMode="contain" source={ResumePlaceholder}/>
                        }
                    </Pressable>
                </View>

                <View style={styles.ButtonContainer}>
                    <LinearGradient
                        colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        end={{x:0.9,y:0.9}}
                        style={styles.ButtonGradient}
                        >
                            <Button icon="arrow-down-bold-box" style={styles.button} labelStyle={{paddingHorizontal:15,paddingVertical:5}} mode="text" color="#ffffff" onPress={()=>{this.downloadFile()}}>
                            <Text style={styles.buttonText}>Download</Text>
                            </Button>
                    </LinearGradient>
                </View>
                <View style={styles.ButtonContainer}>
                    <LinearGradient
                        colors={['rgba(173,127,251,1)','rgba(146,178,253,1)']}
                        end={{x:0.9,y:0.9}}
                        style={styles.ButtonGradient}
                        >
                            <Button icon="share" style={[styles.button,{padding:0}]} labelStyle={{paddingHorizontal:11,paddingVertical:5}} mode="text" color="#ffffff" onPress={this.onShare}>
                               <Text style={styles.buttonText}>Share Link</Text>
                            </Button>
                    </LinearGradient>
                </View>
                
                {
                    this.props.route.params.resume?
                
                        <View style={[styles.ButtonContainer,{backgroundColor:'red',borderRadius:30}]}>
                            <Button icon="delete" style={[styles.button,{padding:0}]} labelStyle={{paddingHorizontal:11,paddingVertical:5}} mode="text" color="#ffffff" onPress={this.onDelete}>
                                <Text style={styles.buttonText}>Delete</Text>
                            </Button>
                        </View>
                    :null
                }
            </View>
            <Modal visible={this.state.preview} transparent={true}>
                <ImageViewer
                imageUrls={this.state.images}
                enableSwipeDown={true}
                onSwipeDown={()=>{this.setState({preview:false})}}
                onCancel={()=>{this.setState({preview:false})}}
                backgroundColor="#444"
                loadingRender={()=><ActivityIndicator size="large" color="#AF7DFB" />}
                saveToLocalByLongPress={false}
                renderHeader={(index) => {
                    return <Pressable
                            onPress={
                                ()=> this.setState({preview:false})
                            }
                            >
                                <MCIcons style={{padding:15}} name="keyboard-backspace" color="#fff" size={30}/>
                            </Pressable>
                    }}
                />
            </Modal>

            <Snackbar
                visible={showSnackbar}
                onDismiss={()=>this.setState({showSnackbar:false})}
                duration={15000}
                action={{
                label: 'Close',
                onPress: () => {
                    this.setState({showSnackbar:false})
                },
                }}>
                {snackbarText}
            </Snackbar>
            <AwesomeAlert
                        show={showAlert}
                        showProgress={showModalProgress}
                        progressColor="#ff00ff"
                        title={modalTitle}
                        message={modalMessage}
                        closeOnTouchOutside={closeOnTouchOutside}
                        closeOnHardwareBackPress={false}
                        showCancelButton={false}
                        showConfirmButton={showConfirmButton}
                        cancelText="No, cancel"
                        confirmText="Yes, delete it"
                        confirmButtonColor="#92B2FD"
                        confirmText={confirmText}
                        onDismiss = {()=>{
                            this.setState({showAlert:false})
                        }}
                        onCancelPressed={() => {
                            this.hideAlert();
                        }}
                        onConfirmPressed={onConfirmPressed}
                        actionContainerStyle={{}}
                        confirmButtonStyle={styles.confirmButtonContainer}
                        confirmButtonTextStyle={styles.buttonText}
                        />
            </>
        )
    }
}

Preview.contextType = ERContext;
export default  withTheme(Preview)

const styles = StyleSheet.create({
    container:{
        flex:1,
        justifyContent: 'center',
        alignItems:'center',
    },
    imageContainer:{
        marginBottom:15,
    },
    resumeImage:{
        height: 400,
        width:300,
        borderRadius:5
    },
    ButtonContainer:{
        marginVertical:10,
        alignItems:'center'
    },
    ButtonGradient:{
        borderRadius:30
    },
    buttonText:{
        marginVertical:20,
        paddingHorizontal:40
    },
    buttonText:{
        fontSize:16
    }
})
