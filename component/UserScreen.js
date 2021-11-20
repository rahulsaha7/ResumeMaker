import React, { Component } from 'react'
import { Text, View } from 'react-native'
import { createStackNavigator } from '@react-navigation/stack';

import Dashboard from './Dashboard';
import ProfileDetails from './ProfileDetails';

export default class UserScreen extends Component {
    render() {
        const Stack = createStackNavigator();
        return (
            <Stack.Navigator
                initialRouteName="Home"
                screenOptions={{
                headerMode: 'screen',
                headerTintColor: 'white',
                headerStyle: { backgroundColor: 'tomato' },
                }}
            >
                <Stack.Screen
                name="Home"
                component={Dashboard}
                options={{
                    headerShown:false,
                }}
                />
                <Stack.Screen
                name="Profile"
                component={ProfileDetails}
                options={{
                    headerShown:false,
                }}
                />
          </Stack.Navigator>
        )
    }
}
